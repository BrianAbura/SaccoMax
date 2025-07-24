<?php

namespace App\Http\Controllers;

use App\Models\Savings;
use App\Models\User;
use App\Models\Withdrawals;
use App\Notifications\WithdrawalsNotification;
use App\Notifications\WithdrawalsUpdateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawals = Withdrawals::select(['user_id'])
            ->selectRaw('SUM(amount) as total_amount')
            ->selectRaw('SUM(charges) as total_charges')
            ->groupBy('user_id')
            ->get();
        return view('staff.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.withdrawals.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount_withdrawn' => 'required',
            'withdrawal_narration' => 'required',
            'withdrawal_date' => 'required',
        ]);

        $member = User::where('id', $request->member_id)->first();
        $amount_withdrawn = strip_tags(str_replace(',', '', $request->amount_withdrawn));
        $charges = strip_tags(str_replace(',', '', $request->charges));

        $sum_savings = Savings::where('user_id', $request->member_id)->sum('amount');
        $sum_withdrawals = Withdrawals::where('user_id', $request->member_id)->sum('amount');
        $cur_balance = $sum_savings - $sum_withdrawals;

        if ($cur_balance < ($amount_withdrawn + $charges)) {
            return redirect()->back()->with('error', $member->first_name . " " . $member->last_name . "'s Saving Balance is Insufficient for this withdrawal");
        }

        $withdrawal = new Withdrawals();
        $withdrawal->user_id = strip_tags($request->member_id);
        $withdrawal->amount = $amount_withdrawn;
        $withdrawal->narration = strip_tags($request->withdrawal_narration);
        $withdrawal->withdrawal_date = strip_tags($request->withdrawal_date);
        $withdrawal->charges = $charges;
        $withdrawal->added_by = Auth::user()->id;
        $withdrawal->save();

        logAudit('Added Withdrawal', 'withdrawals', $withdrawal->id, [], $withdrawal->toArray());

        // Total Savings following withdraw Send Notification
        $total_savings = Savings::where('user_id', $withdrawal->user_id)->sum('amount');
        $total_withdrawals = Withdrawals::where('user_id', $withdrawal->user_id)->sum('amount');
        $total_charges = Withdrawals::where('user_id', $withdrawal->user_id)->sum('charges');
        $balance = $total_savings - $total_withdrawals - $total_charges;

        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'amount' => number_format($withdrawal->amount),
            'narration' => $withdrawal->narration,
            'balance' => number_format($balance),
            'charges' => number_format($charges),
            'updated' => false
        ];

        $member->notify(new WithdrawalsNotification($details));

        return redirect()->route('withdrawals.index')->with('success', $member->first_name . " " . $member->last_name . "'s withdrawal has been added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $member = User::findOrFail($user_id);
        $withdrawals = Withdrawals::where('user_id', $user_id)->get();
        $total_withdrawals = $withdrawals->sum('amount');
        return view('staff.withdrawals.show', [
            'withdrawals' => $withdrawals,
            'total_withdrawals' => $total_withdrawals,
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($withdrawal_id)
    {
        $withdrawal = Withdrawals::findOrFail($withdrawal_id);
        return view('staff.withdrawals.edit', compact('withdrawal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $withdrawal_id)
    {
        $request->validate([
            'amount_withdrawn' => 'required',
            'withdrawal_narration' => 'required',
            'withdrawal_date' => 'required',
        ]);

        $withdrawal = Withdrawals::findOrFail($withdrawal_id);
        $old_withdrawal = $withdrawal->toArray();

        // Update Withdrawal record
        $withdrawal->amount = strip_tags(str_replace(',', '', $request->amount_withdrawn));
        $withdrawal->narration = strip_tags($request->withdrawal_narration);
        $withdrawal->withdrawal_date = strip_tags($request->withdrawal_date);
        $withdrawal->charges = strip_tags(str_replace(',', '', $request->charges));
        $withdrawal->save();

        logAudit('Updated Withdrawal', 'withdrawals', $withdrawal->id, $old_withdrawal, $withdrawal->toArray());


        // Total Savings following withdraw Send Notification
        $total_savings = Savings::where('user_id', $withdrawal->user_id)->sum('amount');
        $total_withdrawals = Withdrawals::where('user_id', $withdrawal->user_id)->sum('amount');
        $total_charges = Withdrawals::where('user_id', $withdrawal->user_id)->sum('charges');
        $balance = $total_savings - $total_withdrawals - $total_charges;

        $details = [
            'fullname' => $withdrawal->member->first_name . ' ' . $withdrawal->member->last_name,
            'amount' => number_format($withdrawal->amount),
            'narration' => $withdrawal->narration,
            'balance' => number_format($balance),
            'charges' => number_format($withdrawal->charges),
            'old_withdrawal_amount' => number_format($old_withdrawal['amount']),
            'updated' => true
        ];

        $withdrawal->member->notify(new WithdrawalsUpdateNotification($details));

        return redirect()->back()->with('success', $withdrawal->member->first_name . " " . $withdrawal->member->last_name . "'s withdrawal has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrawals $withdrawals)
    {
        //
    }
}
