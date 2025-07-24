<?php

namespace App\Http\Controllers;

use App\Models\LoanHistory;
use App\Models\LoanPayment;
use App\Models\Savings;
use Illuminate\Http\Request;
use App\Models\LoanProduct;
use App\Models\LoanRequest;
use App\Models\User;
use App\Models\Withdrawals;
use App\Models\Guarantor;
use App\Notifications\GuarantorActionNotice;
use App\Notifications\GuarantorRequestNotice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberPortalController extends Controller
{
    public function savings()
    {
        $savings = Savings::where('user_id', Auth::user()->id)->get();
        return view('member.savings', compact('savings'));
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawals::where('user_id', Auth::user()->id)->get();
        return view('member.withdrawals', compact('withdrawals'));
    }

    private function recordLoanHistory($loanRequestId, $transactionType, $comment = null)
    {
        $history = new LoanHistory();
        $history->loan_request_id = $loanRequestId;
        $history->transaction_type = $transactionType;
        $history->comment = $comment;
        $history->added_by = Auth::user()->id;
        $history->save();
    }

    public function loan_requests()
    {
        $loan_requests = LoanRequest::where('user_id', Auth::user()->id)
            ->select('loan_requests.*')
            ->selectRaw('
                (SELECT COUNT(*) FROM loan_request_guarantors
                WHERE loan_request_id = loan_requests.id) as total_guarantors,
                (SELECT COUNT(*) FROM loan_request_guarantors
                WHERE loan_request_id = loan_requests.id
                AND status = "approved") as approved_guarantors
            ')
            ->with(['member', 'loanProduct', 'guarantors'])
            ->get();

        return view('member.loan-requests', compact('loan_requests'));
    }

    public function loan_payments()
    {
        $loan_payments = LoanPayment::join('loan_requests', 'loan_payments.loan_request_id', '=', 'loan_requests.id')
            ->where('loan_requests.user_id', Auth::user()->id)
            ->select('loan_payments.*')
            ->orderBy('loan_payments.created_at', 'desc')
            ->get();
        return view('member.loan-payments', compact('loan_payments'));
    }

    public function request_loan()
    {
        $loanProducts = LoanProduct::all();
        // Get all members except the current user for guarantor selection
        $members = User::where('id', '!=', Auth::id())
            ->select('id', 'first_name', 'last_name', 'membership_number')
            ->get()
            ->filter(function ($member) {
                return $member->guarantor_max_limit() > 0;
            })
            ->values();

        return view('member.request-loan', compact('loanProducts', 'members'));
    }

    public function store_loan_request(Request $request)
    {
        $request->validate([
            'loan_product_id' => 'required|exists:loan_products,id',
            'amount' => 'required|string',
            'purpose' => 'required|string',
            'guarantors' => 'required|array|min:1',
            'guarantee_amounts' => 'required|array|min:1',
            'guarantors.*' => 'required|exists:users,id',
            'guarantee_amounts.*' => 'required|string'
        ]);

        // Convert amount from formatted string (1,234,567) to decimal
        $amount = str_replace(',', '', $request->amount);

        $user = User::find(Auth::id());

        // Check if member has a running loan
        $existingLoan = LoanRequest::where('user_id', $user->id)
            ->where('status', '!=', 'Rejected')
            ->first();
        if ($existingLoan) {
            return back()->withErrors(['loan_product_id' => 'You have a running loan request. Please wait for it to be processed.'])
                ->withInput();
        }

        // Get loan product
        $loanProduct = LoanProduct::findOrFail($request->loan_product_id);

        // Check if loan amount is within limits
        if ($amount > $loanProduct->max_loan_amount) {
            return back()->withErrors(['amount' => 'Loan amount exceeds the maximum allowed amount for this product.'])
                ->withInput();
        }

        // Convert and validate guarantee amounts
        $guarantorAmounts = [];
        foreach ($request->guarantee_amounts as $key => $guaranteeAmount) {
            $guarantorId = $request->guarantors[$key];
            $guarantorAmounts[$guarantorId] = str_replace(',', '', $guaranteeAmount);

            // Check if guarantor has enough limit
            $guarantor = User::findOrFail($guarantorId);
            $remainingLimit = Guarantor::remainingGuaranteeLimit($guarantor);
            if ($guarantorAmounts[$guarantorId] > $remainingLimit) {
                return back()->withErrors(['guarantors' => "Guarantor {$guarantor->first_name} {$guarantor->last_name} cannot guarantee more than UGX " . number_format($remainingLimit)])
                    ->withInput();
            }
        }

        // Validate total guaranteed amount matches loan amount
        $totalGuaranteed = array_sum($guarantorAmounts);

        // Calculate user's savings balance
        $userSavingsBalance = $user->net_savings_balance();

        if ($totalGuaranteed + $userSavingsBalance < $amount) {
            return back()->withErrors(['guarantee_amounts' => 'Your current savings balance and guarantors contribution is not enough to cover the loan amount.'])
                ->withInput();
        }

        // Create loan request
        $loanRequest = LoanRequest::create([
            'user_id' => $user->id,
            'loan_product_id' => $request->loan_product_id,
            'amount' => $amount,
            'purpose' => $request->purpose,
            'status' => 'Pending'
        ]);

        logAudit('Member Loan Request', 'loan_requests', $loanRequest->id, [], $loanRequest->toArray());

        // Create guarantors
        foreach ($guarantorAmounts as $guarantorId => $guaranteeAmount) {
            $guarantor = User::findOrFail($guarantorId);

            // Create guarantor record
            $guarantee = Guarantor::create([
                'loan_request_id' => $loanRequest->id,
                'guarantor_id' => $guarantorId,
                'amount' => $guaranteeAmount,
                'status' => 'pending'
            ]);

            // Send Guarantor Notification
            $guarantor->notify(new GuarantorRequestNotice([
                'guarantor_name' => $guarantor->first_name . ' ' . $guarantor->last_name,
                'applicant_name' => $user->first_name . ' ' . $user->last_name,
                'loan_product' => $loanProduct->loan_type,
                'loan_amount' => $amount,
                'guarantor_amount' => $guaranteeAmount,
            ]));
        }

        // Record history
        $this->recordLoanHistory($loanRequest->id, 'Loan Request', 'Loan request submitted by member');

        return redirect()->route('member.loan_requests')
            ->with('success', 'Loan request submitted successfully. Awaiting guarantor approval.');
    }

    public function cancel_loan_request($id)
    {
        $loan_request = LoanRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Pending')
            ->firstOrFail();

        logAudit('Member Loan Cancellation', 'loan_requests', $loan_request->id, $loan_request->toArray(), []);

        // Delete all guarantees for this loan
        $loan_request->guarantees()->delete();

        // Delete the loan request
        $loan_request->delete();

        // Record history
        $this->recordLoanHistory($id, 'Loan Cancellation', 'Loan request cancelled by member');

        return redirect()->route('member.loan_requests')
            ->with('success', 'Loan request cancelled successfully.');
    }

    public function guarantor_requests()
    {
        // Get all guarantees where the current user is a guarantor with related data
        $guarantor_requests = Guarantor::with([
            'loanRequest.member',
            'loanRequest.loanProduct'
        ])
        ->where('guarantor_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('member.guarantor-requests', compact('guarantor_requests'));
    }

    public function approve_guarantor_request(Request $request, $id)
    {
        $guarantor_request = DB::table('loan_request_guarantors')
            ->where('id', $id)
            ->where('guarantor_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$guarantor_request) {
            return back()->with('error', 'Invalid guarantor request or request already processed.');
        }

        DB::table('loan_request_guarantors')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'response_comment' => $request->comments,
                'responded_at' => now()
            ]);

        $loanRequest = LoanRequest::where('id', $guarantor_request->loan_request_id)->first();
        $guarantor = User::findOrFail(Auth::id());
        $member = $loanRequest->member;
        $loanProduct = $loanRequest->loanProduct;
        $amount = $loanRequest->amount;
        $guaranteeAmount = $guarantor_request->amount;

        // Send Notification to Member
        $details = [
            'guarantor_name' => $guarantor->first_name . ' ' . $guarantor->last_name,
            'member_name' => $member->first_name . ' ' . $member->last_name,
            'loan_product' => $loanProduct->loan_type,
            'loan_amount' => $amount,
            'guarantor_amount' => $guaranteeAmount,
            'status' => 'Accepted'
        ];

        $member->notify(new GuarantorActionNotice($details));

        return redirect()->route('member.guarantor-requests')
            ->with('success', 'Guarantor request approved successfully.');
    }

    public function reject_guarantor_request(Request $request, $id)
    {
        $request->validate([
            'comments' => 'required|string|max:500'
        ]);

        $guarantor_request = DB::table('loan_request_guarantors')
            ->where('id', $id)
            ->where('guarantor_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$guarantor_request) {
            return back()->with('error', 'Invalid guarantor request or request already processed.');
        }

        DB::table('loan_request_guarantors')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'response_comment' => $request->comments,
                'responded_at' => now()
            ]);

        $loanRequest = LoanRequest::where('id', $guarantor_request->loan_request_id)->first();
        $guarantor = User::findOrFail(Auth::id());
        $member = $loanRequest->member;
        $loanProduct = $loanRequest->loanProduct;
        $amount = $loanRequest->amount;
        $guaranteeAmount = $guarantor_request->amount;

        // Send Notification to Member
        $details = [
            'guarantor_name' => $guarantor->first_name . ' ' . $guarantor->last_name,
            'member_name' => $member->first_name . ' ' . $member->last_name,
            'loan_product' => $loanProduct->loan_type,
            'loan_amount' => $amount,
            'guarantor_amount' => $guaranteeAmount,
            'status' => 'Declined'
        ];

        $member->notify(new GuarantorActionNotice($details));

        return redirect()->route('member.guarantor-requests')
            ->with('success', 'Guarantor request rejected successfully.');
    }

    public function edit_loan_request($id)
    {
        $loan_request = LoanRequest::with(['loanProduct', 'guarantors'])
            ->findOrFail($id);

        // Check if loan is rejected and belongs to the current user
        if ($loan_request->status !== 'Rejected' || $loan_request->user_id !== Auth::user()->id) {
            return back()->with('error', 'Invalid loan request for editing.');
        }

        $loanProducts = LoanProduct::all();
        // Get all members except the current user for guarantor selection
        $members = User::where('id', '!=', Auth::id())
            ->select('id', 'first_name', 'last_name', 'membership_number')
            ->get()
            ->filter(function ($member) {
                return $member->net_savings_balance() > 0;
            })
            ->values();

        return view('member.edit-loan-request', compact('loan_request', 'loanProducts', 'members'));
    }

    public function update_loan_request(Request $request, $id)
    {
        $loan_request = LoanRequest::findOrFail($id);

        // Validate request
        $request->validate([
            'loan_product_id' => 'required|exists:loan_products,id',
            'amount' => 'required|min:1',
            'purpose' => 'required|string',
            'guarantors' => 'required|array|min:1',
            'guarantee_amounts' => 'required|array|min:1',
            'guarantee_amounts.*' => 'required|string'
        ]);

        // Check if loan is rejected and belongs to the current user
        if ($loan_request->status !== 'Rejected' || $loan_request->user_id !== Auth::user()->id) {
            return back()->with('error', 'Invalid loan request for updating.');
        }

        $amount = str_replace(',', '', $request->amount);

        // Check Members Savings
        $sum_savings = Savings::where('user_id', Auth::id())->sum('amount');
        $sum_withdrawals = Withdrawals::where('user_id', Auth::id())->sum('amount');
        $sum_charges = Withdrawals::where('user_id', Auth::id())->sum('charges');

        $current_savings_balance = $sum_savings - $sum_withdrawals - $sum_charges;

        // Validate loan amount against product maximum
        $loanProduct = LoanProduct::findOrFail($request->loan_product_id);
        if ($amount > $loanProduct->max_loan_amount) {
            return back()->with('error', 'Loan amount exceeds the maximum allowed amount for this product')
                ->withInput();
        }

        // Process guarantors and their amounts
        $guarantors = [];
        $guarantorAmounts = [];
        foreach ($request->guarantors as $index => $guarantorId) {
            $guaranteeAmount = (float) str_replace(',', '', $request->guarantee_amounts[$index]);

            // Check if guarantee amount exceeds loan amount
            if ($guaranteeAmount > $amount) {
                return back()->withErrors(['guarantee_amounts' => 'Guarantee amount cannot be greater than the loan amount.'])
                    ->withInput();
            }

            // Only add if not already processed (handles duplicates)
            if (!in_array($guarantorId, $guarantors)) {
                $guarantors[] = $guarantorId;
                $guarantorAmounts[$guarantorId] = $guaranteeAmount;
            }
        }

        // Validate total guaranteed amount matches loan amount
        $totalGuaranteed = array_sum($guarantorAmounts);
        if ($totalGuaranteed + $current_savings_balance < $amount) {
            return back()->withErrors(['guarantee_amounts' => 'Your current savings balance and guarantors contribution is not enough to cover the loan amount.'])
                ->withInput();
        }

        // Update loan request
        $loanRequest = LoanRequest::findOrFail($id);
        $loanRequest->loan_product_id = $request->loan_product_id;
        $loanRequest->amount = $amount;
        $loanRequest->purpose = $request->purpose;
        $loanRequest->status = 'Pending';
        $loanRequest->rejection_reason = null;
        $loanRequest->rejected_at = null;
        $loanRequest->save();

        logAudit('Member Loan Update', 'loan_requests', $loanRequest->id, $loan_request->toArray(), $loanRequest->toArray());

        $syncData = [];
        foreach ($guarantorAmounts as $guarantorId => $guaranteeAmount) {
            $syncData[$guarantorId] = [
                'amount' => $guaranteeAmount,
                'status' => 'pending',
                'response_comment' => null,
                'responded_at' => null,
                'updated_at' => now()
            ];

            $guarantor = User::findOrFail($guarantorId);

            // Send Guarantor Notification
            $details = [
                'guarantor_name' => $guarantor->first_name . ' ' . $guarantor->last_name,
                'applicant_name' => $loanRequest->member->first_name . ' ' . $loanRequest->member->last_name,
                'loan_product' => $loanProduct->loan_type,
                'loan_amount' => $amount,
                'guarantor_amount' => $guaranteeAmount,
            ];

            $guarantor->notify(new GuarantorRequestNotice($details));
        }
        $loanRequest->guarantors()->sync($syncData);

        // Record history
        $this->recordLoanHistory($id, 'Loan Updatation', 'Loan request updated and resubmitted by member');

        return redirect()->route('member.loan_requests')
            ->with('success', 'Loan request updated and resubmitted successfully. Guarantors will be notified to re-approve.');
    }

    public function resubmit_loan_request($id)
    {
        $loan_request = LoanRequest::findOrFail($id);

        // Check if loan is rejected and belongs to the current user
        if ($loan_request->status !== 'Rejected' || $loan_request->user_id !== Auth::user()->id) {
            return back()->with('error', 'Invalid loan request for resubmission.');
        }

        // Reset guarantor statuses to pending
        $loan_request->resetGuarantors();
        // Send Guarantor Notification
        $guarantors = $loan_request->guarantors()->get();
        foreach ($guarantors as $guarantor) {
            $details = [
                'guarantor_name' => $guarantor->first_name . ' ' . $guarantor->last_name,
                'applicant_name' => $loan_request->member->first_name . ' ' . $loan_request->member->last_name,
                'loan_product' => $loan_request->loanProduct->loan_type,
                'loan_amount' => $loan_request->amount,
                'guarantor_amount' => $guarantor->pivot->amount,
            ];

            $guarantor->notify(new GuarantorRequestNotice($details));
        }

        // Update loan request status
        $loanRequest = LoanRequest::findOrFail($id);
        $loanRequest->status = 'Pending';
        $loanRequest->rejection_reason = null;
        $loanRequest->rejected_at = null;
        $loanRequest->save();

        logAudit('Member Loan Resubmission', 'loan_requests', $loan_request->id, [], $loanRequest->toArray());

        // Record history
        $this->recordLoanHistory($id, 'Loan Resubmission', 'Loan request resubmitted by member');

        return redirect()->route('member.loan_requests')
            ->with('success', 'Loan request resubmitted successfully. Guarantors will be notified to re-approve.');
    }
}
