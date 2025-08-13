<?php

namespace App\Http\Controllers;

use App\Models\Shares;
use App\Models\User;
use App\Notifications\SharesNotification;
use App\Notifications\SharesUpdateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shares = Shares::select(['user_id'])
            ->selectRaw('SUM(share_number * share_amount) as total_amount')
            ->groupBy('user_id')
            ->get();
        return view('staff.shares.index', compact('shares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.shares.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number_of_shares' => 'required',
            'share_price' => 'required',
            'payment_date' => 'required',
            'shares_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $member = User::where('id', $request->member_id)->first();

        if ($request->hasFile('shares_receipt')) {
            $file = $request->file('shares_receipt');
            $fileName = 'Shares_' . $request->member_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('shares_attachments'), $fileName);
            $shares_receipt = 'shares_attachments/' . $fileName;
        } else {
            $shares_receipt = "";
        }

        $share = new Shares();
        $share->user_id = strip_tags($request->member_id);
        $share->share_number = strip_tags(str_replace(',', '', $request->number_of_shares));
        $share->share_amount = strip_tags(str_replace(',', '', $request->share_price));
        $share->payment_date = strip_tags($request->payment_date);
        $share->receipt = $shares_receipt;
        $share->added_by = Auth::user()->id;
        $share->save();

        logAudit('Added Share', 'shares', $share->id, [], $share->toArray());

        // Total Shares and Send Notification
        $total_share = Shares::where('user_id', $share->user_id)
            ->selectRaw('SUM(share_number * share_amount) as total_amount')
            ->value('total_amount');
        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'number_shares' => number_format($share->share_number),
            'share_price' => number_format($share->share_amount),
            'total_share' => number_format($total_share),
            'payment_date' => $share->payment_date,
            'updated' => false
        ];

        $member->notify(new SharesNotification($details));

        return redirect()->route('shares.index')->with('success', $member->first_name . " " . $member->last_name . "'s shares has been added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $member = User::findOrFail($user_id);
        $shares = Shares::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        $total_shares = Shares::where('user_id', $user_id)
            ->selectRaw('SUM(share_number * share_amount) as total_amount')
            ->value('total_amount');
        return view('staff.shares.show', [
            'shares' => $shares,
            'total_shares' => $total_shares,
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($share_id)
    {
        $share = Shares::findOrFail($share_id);
        return view('staff.shares.edit', compact('share'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $share_id)
    {
        $request->validate([
            'number_of_shares' => 'required',
            'share_price' => 'required',
            'payment_date' => 'required',
            'shares_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $share = Shares::findOrFail($share_id);
        $old_share = $share->toArray();

        if ($request->hasFile('shares_receipt')) {
            $file = $request->file('shares_receipt');
            $fileName = 'Shares_Updated' . $share->member->id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('shares_receipts'), $fileName);
            $shares_receipt = 'shares_receipts/' . $fileName;
        } else {
            $shares_receipt = $share->receipt;
        }

        // Update Savings record
        $share->share_number = strip_tags(str_replace(',', '', $request->number_of_shares));
        $share->share_amount = strip_tags(str_replace(',', '', $request->share_price));
        $share->payment_date = strip_tags($request->payment_date);
        $share->receipt = $shares_receipt;
        $share->save();

        logAudit('Updated Share', 'shares', $share->id, $old_share, $share->toArray());

        // Notification when share is updated
        $total_share = Shares::where('user_id', $share->user_id)
            ->selectRaw('SUM(share_number * share_amount) as total_amount')
            ->value('total_amount');
        $details = [
            'fullname' => $share->member->first_name . ' ' . $share->member->last_name,
            'number_shares' => number_format($share->share_number),
            'share_price' => number_format($share->share_amount),
            'total_share' => number_format($total_share),
            'payment_date' => $share->payment_date,
            'updated' => true
        ];

        $share->member->notify(new SharesUpdateNotification($details));
        return redirect()->back()->with('success', $share->member->first_name . " " . $share->member->last_name . "'s shares has been updated successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shares $shares)
    {
        //
    }
}
