<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incomes;
use App\Models\MembershipFee;
use App\Models\User;
use App\Notifications\MembershipFeeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membershipfees = MembershipFee::select(['user_id'])
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('user_id')
            ->get();
        return view('staff.membership-fees.index', compact('membershipfees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.membership-fees.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'membership_fee' => 'required',
            'payment_date' => 'required',
            'membership_fee_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $member = User::where('id', $request->member_id)->first();

        if ($request->hasFile('membership_fee_receipt')) {
            $file = $request->file('membership_fee_receipt');
            $fileName = 'MembershipFee_' . $request->member_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('membership_fees'), $fileName);
            $membership_fee_receipt = 'membership_fees/' . $fileName;
        } else {
            $membership_fee_receipt = "";
        }

        $membershipfee = new MembershipFee();
        $membershipfee->user_id = strip_tags($request->member_id);
        $membershipfee->amount = strip_tags(str_replace(',', '', $request->membership_fee));
        $membershipfee->receipt = $membership_fee_receipt;
        $membershipfee->payment_date = strip_tags($request->payment_date);
        $membershipfee->added_by = Auth::user()->id;
        $membershipfee->save();

        // Add Incomes
        $category_name = Category::where('type', 'Income')->where('name', 'Membership Fee')->first();
        if ($category_name) {
            $category_id = $category_name->id;
        } else {
            $category = new Category();
            $category->name = 'Membership Fee';
            $category->type = 'Income';
            $category->save();
            $category_id = $category->id;
        }

        $income = new Incomes();
        $income->source_type = "Membership Fee";
        $income->source_id = $membershipfee->id;
        $income->category_id = $category_id;
        $income->amount = strip_tags(str_replace(',', '', $request->membership_fee));
        $income->description = "Membership for " . $member->first_name . " " . $member->last_name;
        $income->date_received = strip_tags($request->payment_date);
        $income->attachment = $membership_fee_receipt;
        $income->added_by = Auth::user()->id;
        $income->save();

        logAudit('Added Membership Fee', 'membership_fees', $membershipfee->id, [], $membershipfee->toArray());

        // Membership Fee Send Notification
        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'membership_fee_amount' => number_format($membershipfee->amount),
            'updated' => false
        ];

        $member->notify(new MembershipFeeNotification($details));

        return redirect()->route('fees-membership.index')->with('success', $member->first_name . " " . $member->last_name . "'s membership fee has been added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $member = User::findOrFail($user_id);
        $membershipfee = MembershipFee::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('staff.membership-fees.show', [
            'membershipfee' => $membershipfee,
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($membershipFee_id)
    {
        $membershipfee = MembershipFee::findOrFail($membershipFee_id);
        return view('staff.membership-fees.edit', compact('membershipfee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $membershipFee_id)
    {
        $request->validate([
            'membership_fee' => 'required',
            'payment_date' => 'required',
            'membership_fee_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $membershipfee = MembershipFee::findOrFail($membershipFee_id);
        $old_membershipfee = $membershipfee->toArray();

        if ($request->hasFile('membership_fee_receipt')) {
            $file = $request->file('membership_fee_receipt');
            $fileName = 'MembershipFee_Updated' . $membershipfee->member->id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('membership_fees'), $fileName);
            $membership_fee_receipt = 'membership_fees/' . $fileName;
        } else {
            $membership_fee_receipt = $membershipfee->receipt;
        }

        // Update Savings record
        $membershipfee->amount = strip_tags(str_replace(',', '', $request->membership_fee));
        $membershipfee->payment_date = strip_tags($request->payment_date);
        $membershipfee->receipt = $membership_fee_receipt;
        $membershipfee->save();

        logAudit('Updated Membership Fee', 'membership_fees', $membershipfee->id, $old_membershipfee, $membershipfee->toArray());

        // Membership Fee Send Notification
        $details = [
            'fullname' => $membershipfee->member->first_name . ' ' . $membershipfee->member->last_name,
            'membership_fee_amount' => number_format($membershipfee->amount),
            'updated' => true,
            'old_membership_fee_amount' => number_format($old_membershipfee['amount'])
        ];

        $membershipfee->member->notify(new MembershipFeeNotification($details));

        // Update Incomes
        $income = Incomes::where('source_id', $membershipfee->id)->where('source_type', 'Membership Fee')->first();
        $income->amount = strip_tags(str_replace(',', '', $request->membership_fee));
        $income->date_received = strip_tags($request->payment_date);
        $income->attachment = $membership_fee_receipt;
        $income->added_by = Auth::user()->id;
        $income->save();

        return redirect()->back()->with('success', $membershipfee->member->first_name . " " . $membershipfee->member->last_name . "'s membership fee has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipFee $membershipFee)
    {
        //
    }
}
