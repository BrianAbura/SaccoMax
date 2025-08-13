<?php

namespace App\Http\Controllers;

use App\Models\AnnualFee;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\LoanPayment;
use App\Models\LoanRequest;
use App\Models\MembershipFee;
use App\Models\NextOfKin;
use App\Models\Savings;
use App\Models\Shares;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Withdrawals;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email_address,
            'password' => $request->login_password
        ];

        if (Auth::attempt($credentials)) {
            $member = User::where('email', $request->email_address)->first();
            if ($member->status == 0) {
                return back()->with('error', 'Account De-activated. Please contact Administrator.');
            } else {
                // Check Assigned roles
                logAudit('User Logged In', 'users', $member->id, [], []);
                $member->last_active_at = now();
                $member->save();

                $roles = UserRoles::where('user_id', $member->id)->pluck('roles_id')->toArray();
                if (in_array(1, $roles)) {
                    return redirect()->route('staff.home');
                } elseif (in_array(2, $roles)) {
                    return redirect()->route('member.home');
                }

                return redirect()->route('login')->with('error', 'No valid role assigned.');
            }
        } else {
            return back()->with('error', 'Invalid Email Address or Password.');
        }
    }

    public function staff_home()
    {
        $members = User::count();
        $savings = Savings::sum('amount');
        $withdrawals = Withdrawals::sum('amount');
        $charges = Withdrawals::sum('charges');
        $loan_requests = LoanRequest::where('status', 'Approved')->sum('amount');
        $loan_payments = LoanPayment::sum('amount');
        $incomes = Incomes::sum('amount');
        $expenses = Expenses::sum('amount');
        $shares = Shares::selectRaw('SUM(share_number) as total_number_of_shares, SUM(share_number * share_amount) as total_share_value')->first();
        $membership_fees = MembershipFee::sum('amount');
        $annual_fees = AnnualFee::sum('amount');
        return view('staff.home', [
            'total_members' => $members,
            'total_savings' => $savings,
            'total_withdrawals' => $withdrawals + $charges,
            'loan_requests' => $loan_requests,
            'loan_payments' => $loan_payments,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'shares' => $shares,
            'membership_fees' => $membership_fees,
            'annual_fees' => $annual_fees
        ]);
    }

    public function member_home()
    {
        $savings = Savings::where('user_id', Auth::user()->id)
            ->sum('amount');
        $withdrawals = Withdrawals::where('user_id', Auth::user()->id)
            ->sum('amount');
        $charges = Withdrawals::where('user_id', Auth::user()->id)
            ->sum('charges');
        $membership_fees = MembershipFee::where('user_id', Auth::user()->id)
            ->sum('amount');
        $annual_fees = AnnualFee::where('user_id', Auth::user()->id)
            ->sum('amount');
        $loan_requests = LoanRequest::where('user_id', Auth::user()->id)->where('status', 'Approved')->sum('amount');
        $loan_payments = LoanPayment::whereHas('loanRequest', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->sum('amount');
        $shares = Shares::where('user_id', Auth::user()->id)
            ->selectRaw('SUM(share_number) as total_number_of_shares, SUM(share_number * share_amount) as total_share_value')
            ->first();
        $guarantor_requests = DB::table('loan_request_guarantors')
            ->join('loan_requests', 'loan_request_guarantors.loan_request_id', '=', 'loan_requests.id')
            ->join('users', 'loan_requests.user_id', '=', 'users.id')
            ->join('loan_products', 'loan_requests.loan_product_id', '=', 'loan_products.id')
            ->where('loan_request_guarantors.guarantor_id', Auth::id())
            ->where('loan_request_guarantors.status', 'pending')
            ->select(
                'loan_request_guarantors.amount',
                'loan_request_guarantors.created_at',
                'loan_requests.amount as loan_amount',
                'users.first_name',
                'users.last_name',
                'loan_products.loan_type'
            )
            ->orderBy('loan_request_guarantors.created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'amount' => $item->amount,
                    'created_at' => $item->created_at,
                    'loanRequest' => (object)[
                        'amount' => $item->loan_amount,
                        'member' => (object)[
                            'first_name' => $item->first_name,
                            'last_name' => $item->last_name,
                        ],
                        'loanProduct' => (object)[
                            'loan_type' => $item->loan_type
                        ]
                    ]
                ];
            });
        return view('member.home', [
            'total_savings' => $savings,
            'total_withdrawals' => $withdrawals + $charges,
            'total_loan_requests' => $loan_requests,
            'total_loan_payments' => $loan_payments,
            'total_shares' => $shares,
            'guarantor_requests' => $guarantor_requests,
            'membership_fees' => $membership_fees,
            'annual_fees' => $annual_fees,
        ]);
    }

    public function staff_account_profile()
    {
        $member = User::findOrFail(Auth::user()->id);
        return view('staff.account-profile', compact('member'));
    }

    public function member_account_profile()
    {
        $member = User::findOrFail(Auth::user()->id);
        $next_of_kins = NextOfKin::where('user_id', Auth::user()->id)->get();
        return view('member.account-profile', compact('member', 'next_of_kins'));
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'The passwords do not match. Please try again.');
        }

        $member = User::findOrFail(Auth::user()->id);
        $member->password = Hash::make($request->password);
        $member->save();

        logAudit('Member Changed Password', 'users', $member->id, [], []);

        return back()->with('success', 'Password changed successfully.');
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->with('error', __($status));
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout()
    {
        logAudit('User Logged Out', 'users', Auth::user()->id, [], []);
        Auth::logout();
        return redirect()->route('login')->with('success', 'Session Terminated');
    }

    public function edit_member_profile(Request $request)
    {
        $member = User::findOrFail(Auth::user()->id);
        $old_member = $member->toArray();

        $query_email = User::where('email', $request->email_address)->first();
        if ($query_email && $query_email->id != $member->id) {
            return redirect()->back()->with('edit_error', 'The Email Address is already registered to another member.');
        }

        $query_phone = User::where('phone_number', $request->phone_number)->first();
        if ($query_phone && $query_phone->id != $member->id) {
            return redirect()->back()->with('edit_error', 'The Phone Number is already registered to another member.');
        }

        $member->email = strip_tags($request->email_address);
        $member->phone_number = strip_tags($request->phone_number);
        $member->physical_address = strip_tags($request->physical_address);
        $member->save();

        logAudit('Member Edited Profile', 'users', $member->id, $old_member, $member->toArray());

        return back()->with('edit_success', 'Profile updated successfully.');
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
