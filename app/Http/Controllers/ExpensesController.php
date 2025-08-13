<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expenses::orderBy('created_at', 'desc')->get();
        return view('staff.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'Expense')->get();
        return view('staff.expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date_paid' => 'required',
        ]);

        // Add new category if category is Others
        if ($request->category_id == 'Others') {
            $category = new Category();
            $category->name = $request->new_category;
            $category->type = 'Expense';
            $category->save();
            $category_id = $category->id;
            $category_name = $category->name;
        } else {
            $category_id = $request->category_id;
            $category_name = Category::where('id', $category_id)->first()->name;
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = 'Expense_' . $category_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('expense_attachments'), $fileName);
            $attachment = 'expense_attachments/' . $fileName;
        } else {
            $attachment = "";
        }

        $expense = new Expenses();
        $expense->category_id = $category_id;
        $expense->amount = strip_tags(str_replace(',', '', $request->amount));
        $expense->description = strip_tags($request->description);
        $expense->date_paid = strip_tags($request->date_paid);
        $expense->attachment = $attachment;
        $expense->user_id = Auth::user()->id;
        $expense->save();

        logAudit('Added Expense', 'expenses', $expense->id, [], $expense->toArray());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($expense_id)
    {
        $expense = Expenses::find($expense_id);
        $categories = Category::where('type', 'Expense')->get();
        return view('staff.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $expense_id)
    {
        $expense = Expenses::findOrFail($expense_id);
        $old_expense = $expense->toArray();

        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date_paid' => 'required',
        ]);

        // Add new category if category is Others
        if ($request->category_id == 'Others') {
            $category = new Category();
            $category->name = $request->new_category;
            $category->type = 'Expense';
            $category->save();
            $category_id = $category->id;
            $category_name = $category->name;
        } else {
            $category_id = $request->category_id;
            $category_name = Category::where('id', $category_id)->first()->name;
        }

        // Check file attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = 'Expense_' . $category_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('expense_attachments'), $fileName);
            $attachment = 'expense_attachments/' . $fileName;
        } else {
            $attachment = $expense->attachment;
        }

        $expense->category_id = $category_id;
        $expense->amount = strip_tags(str_replace(',', '', $request->amount));
        $expense->description = strip_tags($request->description);
        $expense->date_paid = strip_tags($request->date_paid);
        $expense->attachment = $attachment;
        $expense->user_id = Auth::user()->id;
        $expense->save();

        logAudit('Updated Expense', 'expenses', $expense->id, $old_expense, $expense->toArray());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        //
    }
}
