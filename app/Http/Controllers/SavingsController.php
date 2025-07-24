<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Savings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SavingsNotification;
use App\Notifications\SavingsUpdateNotification;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savings = Savings::select(['user_id'])
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('user_id')
            ->get();
        return view('staff.savings.index', compact('savings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.savings.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount_saved' => 'required',
            'saving_narration' => 'required',
            'savings_date' => 'required',
            'savings_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $member = User::where('id', $request->member_id)->first();

        if ($request->hasFile('savings_receipt')) {
            $file = $request->file('savings_receipt');
            $fileName = 'Savings_' . $request->member_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('savings_receipts'), $fileName);
            $savings_receipt = 'savings_receipts/' . $fileName;
        } else {
            $savings_receipt = "";
        }

        $saving = new Savings();
        $saving->user_id = strip_tags($request->member_id);
        $saving->amount = strip_tags(str_replace(',', '', $request->amount_saved));
        $saving->payment_mode = strip_tags($request->saving_mode);
        $saving->narration = strip_tags($request->saving_narration);
        $saving->savings_date = strip_tags($request->savings_date);
        $saving->receipt = $savings_receipt;
        $saving->added_by = Auth::user()->id;
        $saving->save();

        logAudit('Added Savings', 'savings', $saving->id, [], $saving->toArray());

        // Total Savings and Send Notification
        $total_savings = Savings::where('user_id', $saving->user_id)->sum('amount');
        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'amount' => number_format($saving->amount),
            'total_savings' => number_format($total_savings),
            'narration' => $saving->narration,
            'updated' => false
        ];

        $member->notify(new SavingsNotification($details));

        return redirect()->route('savings.index')->with('success', $member->first_name . " " . $member->last_name . "'s savings has been added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $member = User::findOrFail($user_id);
        $savings = Savings::where('user_id', $user_id)->get();
        $total_savings = $savings->sum('amount');
        return view('staff.savings.show', [
            'savings' => $savings,
            'total_savings' => $total_savings,
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($savings_id)
    {
        $saving = Savings::findOrFail($savings_id);
        return view('staff.savings.edit', compact('saving'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $savings_id)
    {
        $request->validate([
            'amount_saved' => 'required',
            'saving_narration' => 'required',
            'savings_date' => 'required',
            'savings_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $saving = Savings::findOrFail($savings_id);
        $old_savings = $saving->toArray();

        if ($request->hasFile('savings_receipt')) {
            $file = $request->file('savings_receipt');
            $fileName = 'Savings_Updated' . $saving->member->id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('savings_receipts'), $fileName);
            $savings_receipt = 'savings_receipts/' . $fileName;
        } else {
            $savings_receipt = $saving->receipt;
        }

        // Update Savings record
        $saving->amount = strip_tags(str_replace(',', '', $request->amount_saved));
        $saving->payment_mode = strip_tags($request->saving_mode);
        $saving->narration = strip_tags($request->saving_narration);
        $saving->savings_date = strip_tags($request->savings_date);
        $saving->receipt = $savings_receipt;
        $saving->save();

        logAudit('Updated Savings', 'savings', $saving->id, $old_savings, $saving->toArray());

        // Notification when savings is updated
        $total_savings = Savings::where('user_id', $saving->user_id)->sum('amount');
        $details = [
            'fullname' => $saving->member->first_name . ' ' . $saving->member->last_name,
            'amount' => number_format($saving->amount),
            'total_savings' => number_format($total_savings),
            'narration' => $saving->narration,
            'old_savings_amount' => number_format($old_savings['amount']),
            'updated' => true
        ];

        $saving->member->notify(new SavingsUpdateNotification($details));
        return redirect()->back()->with('success', $saving->member->first_name . " " . $saving->member->last_name . "'s savings has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Savings $savings)
    {
        //
    }
}
