<?php

namespace App\Http\Controllers;

use App\Models\AnnualFee;
use App\Models\Category;
use App\Models\Incomes;
use App\Models\User;
use App\Notifications\AnnualFeeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnualFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annualfees = AnnualFee::select(['user_id'])
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('user_id')
            ->get();
        return view('staff.annual-fees.index', compact('annualfees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::all();
        return view('staff.annual-fees.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'annual_fee' => 'required',
            'fee_year' => 'required',
            'payment_date' => 'required',
            'annual_fee_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $member = User::where('id', $request->member_id)->first();

        if ($request->hasFile('annual_fee_receipt')) {
            $file = $request->file('annual_fee_receipt');
            $fileName = 'AnnualFee_' . $request->member_id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('annual_fees'), $fileName);
            $annual_fee_receipt = 'annual_fees/' . $fileName;
        } else {
            $annual_fee_receipt = "";
        }

        $annualfee = new AnnualFee();
        $annualfee->user_id = strip_tags($request->member_id);
        $annualfee->amount = strip_tags(str_replace(',', '', $request->annual_fee));
        $annualfee->year = strip_tags($request->fee_year);
        $annualfee->receipt = $annual_fee_receipt;
        $annualfee->payment_date = strip_tags($request->payment_date);
        $annualfee->added_by = Auth::user()->id;
        $annualfee->save();

        // Add Incomes
        $category_name = Category::where('type', 'Income')->where('name', 'Annual Fee')->first();
        if ($category_name) {
            $category_id = $category_name->id;
        } else {
            $category = new Category();
            $category->name = 'Annual Fee';
            $category->type = 'Income';
            $category->save();
            $category_id = $category->id;
        }

        $income = new Incomes();
        $income->source_type = "Annual Fee";
        $income->source_id = $annualfee->id;
        $income->category_id = $category_id;
        $income->amount = strip_tags(str_replace(',', '', $request->annual_fee));
        $income->description = "Annual fee for " . $member->first_name . " " . $member->last_name . " for " . $request->fee_year;
        $income->date_received = strip_tags($request->payment_date);
        $income->attachment = $annual_fee_receipt;
        $income->added_by = Auth::user()->id;
        $income->save();

        logAudit('Added Annual Fee', 'annual_fees', $annualfee->id, [], $annualfee->toArray());

        // Annual Fee Send Notification
        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'annual_fee_amount' => number_format($annualfee->amount),
            'fee_year' => $annualfee->year,
            'updated' => false
        ];

        $member->notify(new AnnualFeeNotification($details));

        return redirect()->route('annual-fees.index')->with('success', $member->first_name . " " . $member->last_name . "'s annual fee for " . $request->fee_year . " has been added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $member = User::findOrFail($user_id);
        $annualfee = AnnualFee::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('staff.annual-fees.show', [
            'annualfee' => $annualfee,
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($annualFee_id)
    {
        $annualfee = AnnualFee::findOrFail($annualFee_id);
        return view('staff.annual-fees.edit', compact('annualfee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $annualFee_id)
    {
        $request->validate([
            'annual_fee' => 'required',
            'fee_year' => 'required',
            'payment_date' => 'required',
            'annual_fee_receipt' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $annualfee = AnnualFee::findOrFail($annualFee_id);
        $old_annualfee = $annualfee->toArray();

        if ($request->hasFile('annual_fee_receipt')) {
            $file = $request->file('annual_fee_receipt');
            $fileName = 'AnnualFee_Updated' . $annualfee->member->id . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('annual_fees'), $fileName);
            $annual_fee_receipt = 'annual_fees/' . $fileName;
        } else {
            $annual_fee_receipt = $annualfee->receipt;
        }

        // Update Annual records
        $annualfee->amount = strip_tags(str_replace(',', '', $request->annual_fee));
        $annualfee->year = strip_tags($request->fee_year);
        $annualfee->payment_date = strip_tags($request->payment_date);
        $annualfee->receipt = $annual_fee_receipt;
        $annualfee->save();

        logAudit('Updated Annual Fee', 'annual_fees', $annualfee->id, $old_annualfee, $annualfee->toArray());

        // Annual Fee Send Notification
        $details = [
            'fullname' => $annualfee->member->first_name . ' ' . $annualfee->member->last_name,
            'annual_fee_amount' => number_format($annualfee->amount),
            'old_annual_fee_amount' => number_format($old_annualfee['amount']),
            'fee_year' => $annualfee->year,
            'updated' => true,

        ];

        $annualfee->member->notify(new AnnualFeeNotification($details));

        // Update Incomes
        $income = Incomes::where('source_id', $annualfee->id)->where('source_type', 'Annual Fee')->first();
        $income->amount = strip_tags(str_replace(',', '', $request->annual_fee));
        $income->description = "Annual fee for " . $annualfee->member->first_name . " " . $annualfee->member->last_name . " for " . $request->fee_year;
        $income->date_received = strip_tags($request->payment_date);
        $income->attachment = $annual_fee_receipt;
        $income->added_by = Auth::user()->id;
        $income->save();

        return redirect()->back()->with('success', $annualfee->member->first_name . " " . $annualfee->member->last_name . "'s annual fee " . $request->fee_year . " has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnualFee $annualFee)
    {
        //
    }
}
