<?php

namespace App\Http\Controllers;

use App\Models\LoanPayment;
use App\Models\LoanRequest;
use App\Models\NextOfKin;
use App\Models\Savings;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Withdrawals;
use App\Notifications\LoginEmailNotice;
use App\Services\MemberReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $memberReportService;

    public function __construct(MemberReportService $memberReportService)
    {
        $this->memberReportService = $memberReportService;
    }

    public function reports(Request $request, $type)
    {
        $filters = $request->only(['from', 'to', 'report_type']);

        // Use report_type from filters if available, otherwise use the URL parameter
        $reportType = $filters['report_type'] ?? $type;

        $result = $this->memberReportService->generate($reportType, $filters);

        $headers = match ($reportType) {
            'all' => ['#', 'Fullname', 'Phone Number', 'Date Joined'],
            'inactive' => ['#', 'Fullname', 'Phone Number', 'Last Active', 'Status'],
            'savings' => ['#', 'Fullname', 'Savings'],
            'withdrawals' => ['#', 'Fullname', 'Withdrawals'],
            default => [],
        };

        $title = match ($reportType) {
            'all' => 'Members Report',
            'inactive' => 'Inactive Members Report',
            'savings' => 'Member Savings Report',
            'withdrawals' => 'Member Withdrawals Report',
            default => 'Report',
        };

        $data = isset($result['table']) ? $result['table'] : $result;
        $chartData = isset($result['chart']) ? $result['chart'] : null;

        return view('staff.members.report', compact('data', 'headers', 'title', 'type', 'chartData'));
    }

    public function index()
    {
        $members = User::whereHas('roles', function ($query) {
            $query->where('roles_id', 2);
        })->get();
        return view('staff.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countires = DB::table('countries')->get();
        return view('staff.members.create', ['countires' => $countires]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'membership_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email_address' => 'required|email',
            'physical_address' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $query_email = User::where('email', $request->email_address)->first();
        if ($query_email) {
            return redirect()->back()->with('error', 'The Email Address is already registered to another member.');
        }

        $query_mem_number = User::where('membership_number', $request->membership_number)->first();
        if ($query_mem_number) {
            return redirect()->back()->with('error', 'Membership Number already exists.');
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = 'Profile' . '_' . str_replace('/', '_', $request->membership_number) . '_' . $file->getClientOriginalName();
            $file->move(public_path('member_profiles'), $fileName);
            $profile_picture = 'member_profiles/' . $fileName;
        } else {
            $profile_picture = "";
        }

        $temp_pass = Str::random(6) . rand(100, 999);

        $member = new User();
        $member->membership_number = strip_tags($request->membership_number);
        $member->first_name = strip_tags($request->first_name);
        $member->last_name = strip_tags($request->last_name);
        $member->phone_number = strip_tags($request->phone_number);
        $member->gender = strip_tags($request->gender);
        $member->email = strip_tags($request->email_address);
        $member->physical_address = strip_tags($request->physical_address);
        $member->nationality = strip_tags($request->nationality);
        $member->employer = strip_tags($request->employers_name);
        $member->employer_phone_number = strip_tags($request->employers_number);
        $member->password = Hash::make($temp_pass);;
        $member->profile_picture = $profile_picture;
        $member->status = 1;
        $member->added_by = Auth::user()->id;
        $member->save();

        // Add the member role
        $role = new UserRoles();
        $role->user_id = $member->id;
        $role->roles_id = 2;
        $role->save();

        logAudit('Added Member', 'members', $member->id, [], $member->toArray());

        // Send Login email with unique password
        $details = [
            'fullname' => $member->first_name . ' ' . $member->last_name,
            'email' => $member->email,
            'temp_pass' => $temp_pass
        ];

        $member->notify(new LoginEmailNotice($details));

        return redirect()->route('members.index')->with('success', $member->first_name . ' ' . $member->last_name . ' has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $member = User::findOrFail($user);
        $savings = Savings::where('user_id', $user)->get();
        $withdrawals = Withdrawals::where('user_id', $user)->get();
        $loan_requests = LoanRequest::where('user_id', $user)
            ->select('loan_requests.*')
            ->selectRaw('
            (SELECT COUNT(*) FROM loan_request_guarantors
            WHERE loan_request_id = loan_requests.id) as total_guarantors,
            (SELECT COUNT(*) FROM loan_request_guarantors
            WHERE loan_request_id = loan_requests.id
            AND status = "approved") as approved_guarantors
        ')
            ->with(['member', 'loanProduct', 'guarantors'])
            ->get();

        $next_of_kins = NextOfKin::where('user_id', $user)->get();

        $loan_payments = LoanPayment::join('loan_requests', 'loan_payments.loan_request_id', '=', 'loan_requests.id')
            ->where('loan_requests.user_id', $user)
            ->select('loan_payments.*')
            ->orderBy('loan_payments.created_at', 'desc')
            ->get();
        return view('staff.members.show', ['member' => $member, 'savings' => $savings, 'withdrawals' => $withdrawals, 'loan_requests' => $loan_requests, 'loan_payments' => $loan_payments, 'next_of_kins' => $next_of_kins]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        $member = User::findOrFail($user);
        $countires = DB::table('countries')->get();

        return view('staff.members.edit', ['member' => $member, 'countires' => $countires]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $request->validate([
            'membership_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email_address' => 'required|email',
            'physical_address' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $member = User::findOrFail($user);
        $old_member = $member->toArray();

        $check_member = User::where('email', $request->email_address)->where('id', '!=', $user)->first();
        if ($check_member) {
            return redirect()->back()->with('error', 'The Email Address is already registered to another member.');
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = 'Profile_updated' . '_' . str_replace('/', '_', $request->membership_number) . '_' . $file->getClientOriginalName();
            $file->move(public_path('member_profiles'), $fileName);
            $profile_picture = 'member_profiles/' . $fileName;
        } else {
            $profile_picture = $member->profile_picture;
        }

        $member->membership_number = strip_tags($request->membership_number);
        $member->first_name = strip_tags($request->first_name);
        $member->last_name = strip_tags($request->last_name);
        $member->phone_number = strip_tags($request->phone_number);
        $member->gender = strip_tags($request->gender);
        $member->email = strip_tags($request->email_address);
        $member->physical_address = strip_tags($request->physical_address);
        $member->nationality = strip_tags($request->nationality);
        $member->employer = strip_tags($request->employers_name);
        $member->employer_phone_number = strip_tags($request->employers_number);
        $member->profile_picture = $profile_picture;
        $member->save();

        logAudit('Updated Member', 'members', $member->id, $old_member, $member->toArray());

        return redirect()->back()->with('success', $member->first_name . ' ' . $member->last_name . ' has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        //
    }

    public function change_status(Request $request, $user)
    {
        $member = User::findOrFail($user);
        $old_member = $member->toArray();
        $name = $member->first_name . ' ' . $member->last_name;
        $member->status = strip_tags($request->status);
        $member->updated_at = now();
        $member->save();
        $status = $request->status;

        logAudit('Updated Member Status', 'members', $member->id, $old_member, $member->toArray());

        $statusText = $status == 1 ? 'Activated' : 'Deactivated';
        return back()->with('success', $name . "'s account has been " . $statusText);
    }
}
