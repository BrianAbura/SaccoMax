<?php

namespace App\Http\Controllers;

use App\Models\LoanHistory;
use App\Models\LoanRequest;
use App\Notifications\LoanStatusNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoansController extends Controller
{
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
        // Get all loan requests with their guarantors status and loan history
        $loan_requests = LoanRequest::with(['member', 'loanProduct'])
            ->select('loan_requests.*')
            ->selectRaw('
                (SELECT COUNT(*) FROM loan_request_guarantors
                WHERE loan_request_id = loan_requests.id) as total_guarantors,
                (SELECT COUNT(*) FROM loan_request_guarantors
                WHERE loan_request_id = loan_requests.id
                AND status = "approved") as approved_guarantors
            ')
            ->with(['histories' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.loans.requests', compact('loan_requests'));
    }

    public function approve_loan_request(Request $request, $id)
    {
        $loan_request = LoanRequest::findOrFail($id);

        // Check if all guarantors have approved
        $guarantors_count = $loan_request->guarantors()->count();

        $approved_guarantors = $loan_request->guarantors()
            ->where('loan_request_guarantors.status', 'approved')
            ->count();
        if ($approved_guarantors < $guarantors_count) {
            return back()->with('error', 'Cannot approve loan request. Not all guarantors have approved.');
        }

        // Update loan request status
        $loan_request->update([
            'status' => 'Approved',
            'approved_at' => now(),
            'rejection_reason' => null,
            'rejected_at' => null
        ]);

        // Record history
        $this->recordLoanHistory($id, 'Loan Approval', 'Loan request approved by staff');

        // Send loan approval notification
        $details = [
            'fullname' => $loan_request->member->first_name . ' ' . $loan_request->member->last_name,
            'loan_product' => $loan_request->loanProduct->loan_type,
            'loan_amount' => $loan_request->amount,
            'loan_status' => 'Approved',
            'rejection_reason' => null
        ];

        $loan_request->member->notify(new LoanStatusNotice($details));

        return redirect()->route('staff.loan-requests')
            ->with('success', 'Loan request approved successfully.');
    }

    public function reject_loan_request(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        $loan_request = LoanRequest::findOrFail($id);

        // Record history
        $this->recordLoanHistory($id, 'Loan Rejection', $request->rejection_reason);

        // Update loan request status
        $loan_request->update([
            'status' => 'Rejected',
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        // Send loan rejection notification
        $details = [
            'fullname' => $loan_request->member->first_name . ' ' . $loan_request->member->last_name,
            'loan_product' => $loan_request->loanProduct->loan_type,
            'loan_amount' => $loan_request->amount,
            'loan_status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason
        ];

        $loan_request->member->notify(new LoanStatusNotice($details));

        return redirect()->route('staff.loan-requests')
            ->with('success', 'Loan request rejected successfully.');
    }
}
