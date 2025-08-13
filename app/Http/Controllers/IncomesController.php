<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Incomes::orderBy('created_at', 'desc')->get();
        return view('staff.incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'Income')->get();
        return view('staff.incomes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date_received' => 'required',
        ]);

        // Add new category if category is Others
        if ($request->category_id == 'Others') {
            $category = new Category();
            $category->name = $request->new_category;
            $category->type = 'Income';
            $category->save();
            $category_id = $category->id;
            $category_name = $category->name;
        } else {
            $category_id = $request->category_id;
            $category_name = Category::where('id', $category_id)->first()->name;
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = 'Income_' . $category_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('income_attachments'), $fileName);
            $attachment = 'income_attachments/' . $fileName;
        } else {
            $attachment = "";
        }

        $income = new Incomes();
        $income->source_type = "Manual";
        $income->category_id = $category_id;
        $income->amount = strip_tags(str_replace(',', '', $request->amount));
        $income->description = strip_tags($request->description);
        $income->date_received = strip_tags($request->date_received);
        $income->attachment = $attachment;
        $income->added_by = Auth::user()->id;
        $income->save();

        logAudit('Added Income', 'incomes', $income->id, [], $income->toArray());

        return redirect()->route('incomes.index')->with('success', 'Income added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incomes $incomes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($income_id)
    {
        $income = Incomes::findOrFail($income_id);
        $categories = Category::where('type', 'Income')->get();
        return view('staff.incomes.edit', compact('income', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $income_id)
    {
        $income = Incomes::findOrFail($income_id);
        $old_income = $income->toArray();

        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date_received' => 'required',
        ]);

        // Add new category if category is Others
        if ($request->category_id == 'Others') {
            $category = new Category();
            $category->name = $request->new_category;
            $category->type = 'Income';
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
            $fileName = 'Income_' . $category_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('income_attachments'), $fileName);
            $attachment = 'income_attachments/' . $fileName;
        } else {
            $attachment = $income->attachment;
        }

        $income->category_id = $category_id;
        $income->amount = strip_tags(str_replace(',', '', $request->amount));
        $income->description = strip_tags($request->description);
        $income->date_received = strip_tags($request->date_received);
        $income->attachment = $attachment;
        $income->added_by = Auth::user()->id;
        $income->save();

        logAudit('Updated Income', 'incomes', $income->id, $old_income, $income->toArray());

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incomes $incomes)
    {
        //
    }
}
