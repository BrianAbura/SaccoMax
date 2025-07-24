<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = LoanProduct::all();
        return view('staff.loan-product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.loan-product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'loan_type' => 'required',
            'max_loan_amount' => 'required',
            'loan_period' => 'required|integer',
            'annual_interest_rate' => 'required|numeric|max:100',
        ]);

        $product = new LoanProduct();
        $product->loan_type = $request->loan_type;
        $product->max_loan_amount = strip_tags(str_replace(',', '', $request->max_loan_amount));
        $product->loan_period = strip_tags($request->loan_period);
        $product->annual_interest_rate = strip_tags($request->annual_interest_rate);
        $product->monthly_interest_rate = strip_tags($request->annual_interest_rate / 12);
        $product->grace_period = strip_tags($request->grace_period);
        $product->payment_frequency = strip_tags($request->payment_frequency);
        $product->user_id = Auth::user()->id;
        $product->save();

        logAudit('Created Loan Product', 'loan_products', $product->id, [], $product->toArray());

        return redirect()->route('loan-product.index')->with('success',  $request->loan_type . ' has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanProduct $loanSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = LoanProduct::findOrFail($id);
        return view('staff.loan-product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'loan_type' => 'required',
            'max_loan_amount' => 'required',
            'loan_period' => 'required|integer',
            'annual_interest_rate' => 'required|numeric|max:100',
        ]);

        $product = LoanProduct::findOrFail($id);
        $old_product = $product->toArray();
        $product->loan_type = $request->loan_type;
        $product->max_loan_amount = strip_tags(str_replace(',', '', $request->max_loan_amount));
        $product->loan_period = strip_tags($request->loan_period);
        $product->annual_interest_rate = strip_tags($request->annual_interest_rate);
        $product->monthly_interest_rate = strip_tags($request->annual_interest_rate / 12);
        $product->grace_period = strip_tags($request->grace_period);
        $product->payment_frequency = strip_tags($request->payment_frequency);
        $product->user_id = Auth::user()->id;
        $product->save();

        logAudit('Updated Loan Product', 'loan_products', $product->id, $old_product, $product->toArray());

        return redirect()->route('loan-product.index')->with('success',  $product->loan_type . ' has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanProduct $loanSettings)
    {
        //
    }
}
