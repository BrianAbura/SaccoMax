<?php

namespace App\Http\Controllers;

use App\Models\AnnualFee;
use App\Models\BalanceSheetManual;
use App\Models\BalanceSheetSubCategories;
use App\Models\Savings;
use App\Models\Incomes;
use App\Models\Expenses;
use App\Models\MembershipFee;
use App\Models\Shares;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceSheetManualController extends Controller
{
    public function balance_sheet_sub_categories()
    {
        $sub_categories = BalanceSheetSubCategories::all();
        return view('staff.bal-sheet-sub-categories.index', compact('sub_categories'));
    }

    public function store_sub_category(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:Assets,Liabilities,Equity',
            'description' => 'required|string|max:255',
        ]);

        $subCategory = new BalanceSheetSubCategories();
        $subCategory->category = $request->category;
        $subCategory->name = $request->description;
        $subCategory->user_id = Auth::user()->id;
        $subCategory->save();

        return redirect()->route('staff.balance-sheet-sub-categories')
            ->with('success', 'Sub-category created successfully.');
    }

    /**
     * Update the specified sub-category in storage.
     */
    public function update_sub_category(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|in:Assets,Liabilities,Equity',
            'description' => 'required|string|max:255',
        ]);

        $subCategory = BalanceSheetSubCategories::findOrFail($id);
        $subCategory->category = $request->category;
        $subCategory->name = $request->description;
        $subCategory->user_id = Auth::user()->id;
        $subCategory->save();

        return redirect()->route('staff.balance-sheet-sub-categories')
            ->with('success', 'Sub-category updated successfully.');
    }

    public function index()
    {
        $balanceSheetEntries = BalanceSheetManual::all();
        return view('staff.bal-sheet-entry.index', compact('balanceSheetEntries'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sub_categories = BalanceSheetSubCategories::all();
        return view('staff.bal-sheet-entry.create', compact('sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'sub_category_id' => 'required|exists:balance_sheet_sub_categories,id',
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string',
            'amount' => 'required',
            'date_added' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = 'BalanceSheet_' . $request->item_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('balance_sheet_attachments'), $fileName);
            $attachment = 'balance_sheet_attachments/' . $fileName;
        } else {
            $attachment = "";
        }

        $entry = new BalanceSheetManual();
        $entry->category = $request->category;
        $entry->balance_sheet_sub_categories_id = $request->sub_category_id;
        $entry->item_name = strip_tags($request->item_name);
        $entry->item_description = strip_tags($request->item_description);
        $entry->item_value = strip_tags(str_replace(',', '', $request->amount));
        $entry->date = strip_tags($request->date_added);
        $entry->attachment = $attachment;
        $entry->user_id = Auth::user()->id;
        $entry->save();

        logAudit('Added Balance Sheet Entry', 'balance_sheet_manual', $entry->id, [], $entry->toArray());

        return redirect()->route('balance-sheet-entires.index')->with('success', 'Balance Sheet Entry added successfully');
    }

    /**
     * Store a newly created sub-category in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(BalanceSheetManual $balanceSheetManual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sub_categories = BalanceSheetSubCategories::all();
        $entry = BalanceSheetManual::findOrFail($id);
        return view('staff.bal-sheet-entry.edit', compact('sub_categories', 'entry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'sub_category_id' => 'required|exists:balance_sheet_sub_categories,id',
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string',
            'amount' => 'required',
            'date_added' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $entry = BalanceSheetManual::findOrFail($id);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = 'BalanceSheet_' . $request->item_name . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('balance_sheet_attachments'), $fileName);
            $attachment = 'balance_sheet_attachments/' . $fileName;
        } else {
            $attachment = $entry->attachment;
        }

        $entry->category = $request->category;
        $entry->balance_sheet_sub_categories_id = $request->sub_category_id;
        $entry->item_name = strip_tags($request->item_name);
        $entry->item_description = strip_tags($request->item_description);
        $entry->item_value = strip_tags(str_replace(',', '', $request->amount));
        $entry->date = strip_tags($request->date_added);
        $entry->attachment = $attachment;
        $entry->user_id = Auth::user()->id;
        $entry->save();

        logAudit('Updated Balance Sheet Entry', 'balance_sheet_manual', $entry->id, [], $entry->toArray());

        return redirect()->route('balance-sheet-entires.index')->with('success', 'Balance Sheet Entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $entry = BalanceSheetManual::findOrFail($id);
        $entry->delete();

        logAudit('Deleted Balance Sheet Entry', 'balance_sheet_manual', $entry->id, [], $entry->toArray());

        return redirect()->route('balance-sheet-entires.index')->with('success', 'Balance Sheet Entry deleted successfully');
    }

    public function balance_sheet(Request $request, $period)
    {
        // Set default date range: January 1st of current year to today
        $currentYear = date('Y');
        $defaultFrom = $currentYear . '-01-01';
        $defaultTo = date('Y-m-d');

        // Get date filters from request or use defaults
        $from = $request->input('from', $defaultFrom);
        $to = $request->input('to', $defaultTo);

        // Build query with date filtering
        $query = function ($q) use ($from, $to) {
            return $q->whereBetween('date', [$from, $to]);
        };

        // Get Assets grouped by sub-category
        $assets = BalanceSheetSubCategories::where('category', 'Assets')
            ->with(['entries' => $query])
            ->get()
            ->map(function ($subCategory) {
                $total = $subCategory->entries->sum('item_value');
                return [
                    'sub_category' => $subCategory->name,
                    'items' => $subCategory->entries,
                    'total' => $total
                ];
            })
            ->filter(function ($item) {
                return $item['total'] > 0 || $item['items']->count() > 0;
            });

        // Calculate total NET Members Savings (cumulative up to end date)
        $totalMembersSavings = Savings::where('savings_date', '<=', $to)->sum('amount');
        $totalMembersWithdrawals = Withdrawals::where('withdrawal_date', '<=', $to)
            ->sum(DB::raw('amount + charges'));

        $totalNetMembersSavings = $totalMembersSavings - $totalMembersWithdrawals;

        // Get Liabilities grouped by sub-category
        $liabilities = BalanceSheetSubCategories::where('category', 'Liabilities')
            ->with(['entries' => $query])
            ->get()
            ->map(function ($subCategory) use ($totalNetMembersSavings) {
                $total = $subCategory->entries->sum('item_value');

                // Add Members Savings to Current Liabilities sub-category
                if ($subCategory->name === 'Current Liabilities' && $totalNetMembersSavings > 0) {
                    $total += $totalNetMembersSavings;
                }

                return [
                    'sub_category' => $subCategory->name,
                    'items' => $subCategory->entries,
                    'total' => $total,
                    'members_net_savings' => ($subCategory->name === 'Current Liabilities') ? $totalNetMembersSavings : 0
                ];
            })
            ->filter(function ($item) {
                return $item['total'] > 0 || $item['items']->count() > 0;
            });

        // Calculate Retained Earnings (Total Income - Total Expenses) up to end date
        $totalIncome = Incomes::where('date_received', '<=', $to)->sum('amount');
        $totalExpenses = Expenses::where('date_paid', '<=', $to)->sum('amount');
        $retainedEarnings = $totalIncome - $totalExpenses;

        // Equity Section
        // Get Equity grouped by sub-category
        $equity = BalanceSheetSubCategories::where('category', 'Equity')
            ->with(['entries' => $query])
            ->get()
            ->map(function ($subCategory) {
                $total = $subCategory->entries->sum('item_value');
                return [
                    'sub_category' => $subCategory->name,
                    'items' => $subCategory->entries,
                    'total' => $total
                ];
            })
            ->filter(function ($item) {
                return $item['total'] > 0 || $item['items']->count() > 0;
            });

        // Add Retained Earnings as a separate item under Equity
        if ($retainedEarnings != 0) {
            $equity->push([
                'sub_category' => 'Retained Earnings',
                'items' => collect([]),
                'total' => $retainedEarnings,
                'is_retained_earnings' => true
            ]);
        }

        // Share Capital
        $share_capital = Shares::selectRaw('SUM(share_number) as total_number_of_shares, SUM(share_number * share_amount) as total_share_value')
            ->where('payment_date', '<=', $to)
            ->first();
        if ($share_capital->total_share_value != 0) {
            $equity->push([
                'sub_category' => 'Share Capital',
                'items' => collect([]),
                'total' => $share_capital->total_share_value,
                'is_share_capital' => true
            ]);
        }

        // Membership and Annual Fees
        $totalMembershipFees = MembershipFee::where('payment_date', '<=', $to)->sum('amount');
        $totalAnnualFees = AnnualFee::where('payment_date', '<=', $to)->sum('amount');
        $totalMembershipAndAnnualFees = $totalMembershipFees + $totalAnnualFees;

        // Add Membership and Annual Fees as a separate item under Equity
        if ($totalMembershipAndAnnualFees != 0) {
            $equity->push([
                'sub_category' => 'Membership and Annual Fees',
                'items' => collect([]),
                'total' => $totalMembershipAndAnnualFees,
                'is_membership_and_annual_fees' => true
            ]);
        }

        // Calculate totals
        $totalAssets = $assets->sum('total');
        $totalLiabilities = $liabilities->sum('total');
        $totalEquity = $equity->sum('total');

        return view('staff.bal-sheet-entry.report', compact(
            'assets',
            'liabilities',
            'equity',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'period',
            'from',
            'to'
        ));
    }
}
