<?php

use App\Http\Controllers\LoanPaymentsController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\LoanSettingsController;
use App\Http\Controllers\MemberPortalController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalsController;
use App\Http\Controllers\NextOfKinController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('user-login');
Route::get('forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

Route::post('forgot-password', [UserController::class, 'forgot_password'])->name('password.email');
Route::get('/reset-password/{token}', function (string $token) {
    return view('reset-password', ['token' => $token]);
})->name('password.reset');
Route::post('reset-password', [UserController::class, 'reset_password'])->name('password.update');

Route::middleware('auth')->group(function () {
    // Staff Management
    Route::get('/staff/home', [UserController::class, 'staff_home'])->name('staff.home');
    Route::get('/staff/account-profile', [UserController::class, 'staff_account_profile'])->name('staff.account_profile');
    // Member Portal Management
    Route::get('/member/home', [UserController::class, 'member_home'])->name('member.home');
    Route::get('/member/account-profile', [UserController::class, 'member_account_profile'])->name('member.account_profile');
    Route::post('change-password', [UserController::class, 'change_password'])->name('change_password');

    // Content Relevant to the Member portal
    Route::get('/member/savings', [MemberPortalController::class, 'savings'])->name('member.savings');
    Route::get('/member/withdrawals', [MemberPortalController::class, 'withdrawals'])->name('member.withdrawals');

    // Loan Management Routes
    Route::get('/member/loan-requests', [MemberPortalController::class, 'loan_requests'])->name('member.loan_requests');
    Route::get('/member/request-loan', [MemberPortalController::class, 'request_loan'])->name('member.request-loan');
    Route::post('/member/store-loan-request', [MemberPortalController::class, 'store_loan_request'])->name('member.store-loan-request');
    Route::get('/member/cancel-loan-request/{id}', [MemberPortalController::class, 'cancel_loan_request'])->name('member.cancel-loan-request');
    Route::get('/member/loan-requests/{id}/edit', [MemberPortalController::class, 'edit_loan_request'])->name('member.edit-loan-request');
    Route::post('/member/loan-requests/{id}/update', [MemberPortalController::class, 'update_loan_request'])->name('member.update-loan-request');
    Route::post('/member/loan-requests/{id}/resubmit', [MemberPortalController::class, 'resubmit_loan_request'])->name('member.resubmit-loan-request');

    Route::get('/member/loan-payments', [MemberPortalController::class, 'loan_payments'])->name('member.loan-payments');

    // Guarantor Routes
    Route::get('/member/guarantor-requests', [MemberPortalController::class, 'guarantor_requests'])->name('member.guarantor-requests');
    Route::post('/member/approve-guarantor-request/{id}', [MemberPortalController::class, 'approve_guarantor_request'])->name('member.approve-guarantor-request');
    Route::post('/member/reject-guarantor-request/{id}', [MemberPortalController::class, 'reject_guarantor_request'])->name('member.reject-guarantor-request');

    Route::resource('staff/savings', SavingsController::class);
    Route::resource('staff/withdrawals', WithdrawalsController::class);
    Route::resource('staff/messages', MessageController::class);
    Route::resource('staff/next-of-kin', NextOfKinController::class);
    Route::resource('staff/audit-logs', AuditLogController::class);

    // Staff Loan Action
    Route::get('/staff/loan-requests', [LoansController::class, 'loan_requests'])->name('staff.loan-requests');
    Route::post('/staff/loan-requests/{id}/approve', [LoansController::class, 'approve_loan_request'])->name('staff.approve-loan-request');
    Route::post('/staff/loan-requests/{id}/reject', [LoansController::class, 'reject_loan_request'])->name('staff.reject-loan-request');

    // Staff Loan Payments
    Route::get('/staff/loan-payments', [LoanPaymentsController::class, 'index'])->name('staff.loan-payments.index');
    Route::get('/staff/loan-payments/{id}', [LoanPaymentsController::class, 'show'])->name('staff.loan-payments.show');
    Route::post('/staff/loan-payments', [LoanPaymentsController::class, 'store'])->name('staff.loan-payments.store');
    Route::put('/staff/loan-payments/{id}', [LoanPaymentsController::class, 'update'])->name('staff.loan-payments.update');

    Route::post('logout', [UserController::class, 'logout'])->name('user-logout');

    Route::post('members/{id}/change_status', [MembersController::class, 'change_status'])->name('members.change_status');
    Route::resource('staff/members', MembersController::class);
    Route::get('staff/members/report/{type}', [MembersController::class, 'reports'])->name('staff.members.report');
    Route::resource('staff/loan-product', LoanProductController::class);
});
