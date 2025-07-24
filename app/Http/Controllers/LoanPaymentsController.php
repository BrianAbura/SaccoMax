<?php

namespace App\Http\Controllers;

use App\Models\LoanHistory;
use App\Models\LoanPayment;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanPaymentsController extends Controller
{
    public function index()
    {
        $loans = LoanRequest::with(['member', 'payments'])
            ->select('loan_requests.*')
            ->selectRaw('COALESCE(SUM(loan_payments.amount), 0) as total_paid')
            ->leftJoin('loan_payments', 'loan_requests.id', '=', 'loan_payments.loan_request_id')
            ->where('loan_requests.status', 'Approved')
            ->groupBy('loan_requests.id')
            ->orderBy('loan_requests.created_at', 'desc')
            ->get();

        return view('staff.loan-payments.index', compact('loans'));
    }

    public function show($id)
    {
        $loan = LoanRequest::with(['member', 'loanProduct'])->findOrFail($id);
        $payments = LoanPayment::where('loan_request_id', $id)
            ->with('recordedBy')
            ->orderBy('created_at', 'desc')
            ->get();

        $total_paid = $payments->sum('amount');

        return view('staff.loan-payments.show', compact('loan', 'payments', 'total_paid'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_request_id' => 'required|exists:loan_requests,id',
            'amount' => 'required|min:0',
            'payment_method' => 'required|string',
            'payment_receipt' => 'image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string'
        ]);

        $amount = str_replace(',', '', $request->amount);

        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $fileName = 'LoanPayment_' . $request->loan_request_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('loan_payment_receipts'), $fileName);
            $payment_receipt = 'loan_payment_receipts/' . $fileName;
        } else {
            $payment_receipt = null;
        }

        // Create the payment record
        $payment = new LoanPayment();
        $payment->loan_request_id = $request->loan_request_id;
        $payment->amount = $amount;
        $payment->payment_method = $request->payment_method;
        $payment->receipt = $payment_receipt;
        $payment->narration = $request->notes;
        $payment->recorded_by = Auth::id();
        $payment->save();

        // Record in loan history
        $history = new LoanHistory();
        $history->loan_request_id = $request->loan_request_id;
        $history->transaction_type = 'Loan Payment';
        $history->comment = "Payment of UGX " . number_format($amount) . " received via " . $request->payment_method;
        $history->added_by = Auth::id();
        $history->save();

        logAudit('Recorded Loan Payment', 'loan_payments', $payment->id, [], $payment->toArray());

        return redirect()->back()->with('success', 'Payment recorded successfully');
    }

    public function update(Request $request, $id)
    {
        $payment = LoanPayment::findOrFail($id);
        $old_payment = $payment->toArray();

        $request->validate([
            'amount' => 'required|min:0',
            'payment_method' => 'required|string',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string'
        ]);

        $amount = str_replace(',', '', $request->amount);

        if ($request->hasFile('payment_receipt')) {
            // Delete old receipt if exists
            if ($payment->receipt && file_exists(public_path($payment->receipt))) {
                unlink(public_path($payment->receipt));
            }

            $file = $request->file('payment_receipt');
            $fileName = 'LoanPayment_' . $payment->loan_request_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('loan_payment_receipts'), $fileName);
            $payment_receipt = 'loan_payment_receipts/' . $fileName;
        } else {
            $payment_receipt = $payment->receipt;
        }

        // Update the payment record
        $payment->amount = $amount;
        $payment->payment_method = $request->payment_method;
        $payment->receipt = $payment_receipt;
        $payment->narration = $request->notes;
        $payment->save();

        // Record in loan history
        $history = new LoanHistory();
        $history->loan_request_id = $payment->loan_request_id;
        $history->transaction_type = 'Payment Update';
        $history->comment = "Payment updated to UGX " . number_format($amount) . " via " . $request->payment_method;
        $history->added_by = Auth::id();
        $history->save();

        logAudit('Updated Loan Payment', 'loan_payments', $payment->id, $old_payment, $payment->toArray());

        return redirect()->back()->with('success', 'Payment updated successfully');
    }
}
