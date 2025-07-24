@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Member Profile</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Member Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="user-profile">
                <div class="row">
                    {{-- Alerts for the home page --}}
                    @if (session('success'))
                        <div class="alert alert-light-success alert-dismissible fade show mx-auto mb-3" role="alert">
                            <p class="txt-info"> {{ session('success') }}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-light-secondary alert-dismissible fade show mx-auto mb-3" role="alert">
                            <p class="txt-info"> {{ session('error') }}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- Alerts for the home page --}}
                    <!-- user profile first-style start-->
                    <div class="col-sm-12">
                        <div class="card hovercard text-center mt-3">
                            <div class="user-image mt-5">
                                <div class="avatar">
                                    @if (!empty($member->profile_picture))
                                        <img alt="" src="{{ asset($member->profile_picture) }}">
                                    @else
                                        <img alt="" src="{{ asset('assets/images/logo/upplogo-nobg.png') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-envelope"></i>   Email</h6>
                                                    <span class="txt-info"> {{ $member->email }} </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-user"></i>   Gender</h6><span
                                                        class="txt-info">{{ $member->gender }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                        <div class="user-designation">
                                            <div class="title"><a target="_blank" href=""
                                                    class="txt-info">{{ $member->first_name . ' ' . $member->last_name }}</a>
                                            </div>
                                            <div class="desc txt-primary">{{ $member->membership_number }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-phone"></i>   Phone Number</h6><span
                                                        class="txt-info">{{ $member->phone_number }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-location-arrow"></i>   Physical
                                                        Address</h6><span
                                                        class="txt-info">{{ $member->physical_address }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-flag"></i>   Nationality</h6>
                                            <span class="txt-info"> {{ $member->nationality }} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-user"></i>   Employer</h6><span
                                                class="txt-info">{{ $member->employer }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-phone"></i>   Employer Number</h6>
                                            <span class="txt-info">{{ $member->employer_phone_number }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-signal"></i>   Account Status</h6>
                                            @if ($member->status == 1)
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-gears"></i>   Actions</h6>
                                            <ul class="d-flex list-unstyled gap-2">
                                                <li><a href="{{ route('members.edit', $member->id) }}">Edit</a></li>
                                                <li>|</li>
                                                <li>
                                                    @if ($member->status == 1)
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deactivateAccount">Deactivate</a>
                                                    @else
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#activateAccount">Activate</a>
                                                    @endif
                                                </li>
                                                {{-- <li>|</li>
                                                <li><a href="#" onclick="history(0)">History</a></li>
                                                <li>|</li>
                                                <li><a href="#" onclick="printContact(0)" data-bs-toggle="modal"
                                                        data-bs-target="#printModal">Print</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- De-activate Account start --}}
                        <div class="modal fade" id="deactivateAccount" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenter1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-toggle-wrapper">
                                            <ul class="modal-img">
                                                <li> <img src="{{ asset('assets/images/gif/danger.gif') }}"
                                                        alt="error"></li>
                                            </ul>
                                            <h4 class="text-center pb-1 txt-danger">Account Deactivation</h4>
                                            <p class="text-center">Are you sure you want to deactivate
                                                <strong>{{ $member->first_name . ' ' . $member->last_name }}'s</strong>
                                                account? This will revoke the member's access to their profile, data, and
                                                any
                                                associated
                                                services.
                                            </p>
                                            <form action="{{ route('members.change_status', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="0">
                                                <button class="btn btn-success d-flex m-auto" type="submit"
                                                    data-bs-dismiss="modal">Proceed</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Deactivate Account end --}}
                        {{-- Activate Account start --}}
                        <div class="modal fade" id="activateAccount" tabindex="-1" role="dialog"
                            aria-labelledby="activateAccount" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-toggle-wrapper">
                                            <ul class="modal-img">
                                                <li> <img
                                                        src="{{ asset('assets/images/gif/dashboard-8/successful.gif') }}"
                                                        alt="error"></li>
                                            </ul>
                                            <h4 class="text-center pb-1 txt-success">Account Activation</h4>
                                            <p class="text-center">Activating
                                                <strong>{{ $member->first_name . ' ' . $member->last_name }}'s</strong>
                                                account will grant the member access to their profile, data, and
                                                any
                                                associated
                                                services.
                                            </p>
                                            <form action="{{ route('members.change_status', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="1">
                                                <button class="btn btn-success d-flex m-auto" type="submit"
                                                    data-bs-dismiss="modal">Proceed</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Activate Account end --}}
                    </div>
                    <!-- user profile first-style end-->
                    <!-- user profile fifth-style start-->
                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h5>Activities</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="pills-savings-tab"
                                            data-bs-toggle="pill" href="#pills-savings" role="tab"
                                            aria-controls="pills-savings" aria-selected="true">Savings</a></li>
                                    <li class="nav-item"><a class="nav-link" id="pills-withdrawals-tab"
                                            data-bs-toggle="pill" href="#pills-withdrawals" role="tab"
                                            aria-controls="pills-withdrawals" aria-selected="false">Withdrawals</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="pills-loan_requests-tab"
                                            data-bs-toggle="pill" href="#pills-loan_requests" role="tab"
                                            aria-controls="pills-loan_requests" aria-selected="false">Loan Requests</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="pills-loan_payments-tab"
                                            data-bs-toggle="pill" href="#pills-loan_payments" role="tab"
                                            aria-controls="pills-loan_payments" aria-selected="false">Loan Payments </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    {{-- Start Savings Panel --}}
                                    <div class="tab-pane fade show active" id="pills-savings" role="tabpanel"
                                        aria-labelledby="pills-savings-tab">
                                        <div class="card-body">
                                            <div class="table-responsive custom-scrollbar">
                                                <table class="display basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Amount</th>
                                                            <th>Saving Mode</th>
                                                            <th>Saving Narration</th>
                                                            <th>Savings Date</th>
                                                            <th class="text-center">Proof of Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($savings as $saving)
                                                            @php
                                                                $cnt = $loop->iteration;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $cnt }}</td>
                                                                <td class="text-primary">UGX
                                                                    {{ number_format($saving->amount) }}</td>
                                                                <td>{{ $saving->payment_mode }}</td>
                                                                <td>{{ $saving->narration }}</td>
                                                                <td> {{ date('d-m-Y', strtotime($saving->savings_date)) }}
                                                                </td>
                                                                <td class="text-center">
                                                                    @if (!empty($saving->receipt))
                                                                        <a href="#" class="open-modal"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                            data-image="{{ asset($saving->receipt) }}">
                                                                            <img class="b-r-10"
                                                                                src="{{ asset($saving->receipt) }}"
                                                                                width="30px" height="40px">
                                                                        </a>
                                                                    @else
                                                                        <i class="icofont icofont-close-squared-alt h4"
                                                                            title="No file attached"></i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                                        <div class="modal fade" id="imageModal" tabindex="-1"
                                                            aria-labelledby="imageModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Receipt Preview</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img id="modalImage" src=""
                                                                            class="img-fluid b-r-10">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Savings Panel --}}
                                    {{-- start withdrawal panel --}}
                                    <div class="tab-pane fade" id="pills-withdrawals" role="tabpanel"
                                        aria-labelledby="pills-withdrawals-tab">
                                        <div class="card-body">
                                            <div class="table-responsive custom-scrollbar">
                                                <table class="display basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Amount</th>
                                                            <th>Withdrawal Narration</th>
                                                            <th>Withdrawal Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($withdrawals as $withdrawal)
                                                            @php
                                                                $cnt = $loop->iteration;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $cnt }}</td>
                                                                <td class="text-primary">UGX
                                                                    {{ number_format($withdrawal->amount) }}</td>
                                                                <td>{{ $withdrawal->narration }}</td>
                                                                <td> {{ date('d-m-Y', strtotime($withdrawal->withdrawal_date)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end withdrawl panel --}}
                                    {{-- Start Loan Request Panel --}}
                                    <div class="tab-pane fade" id="pills-loan_requests" role="tabpanel"
                                        aria-labelledby="pills-loan_requests-tab">
                                        <div class="card-body">
                                            <div class="table-responsive custom-scrollbar">
                                                <table class="display basic-1" id="basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Loan Product</th>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Status</th>
                                                            <th>Guarantors</th>
                                                            <th>Date Applied</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($loan_requests as $loan_request)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $loan_request->loanProduct->loan_type }}</td>
                                                                <td class="text-primary">UGX
                                                                    {{ number_format($loan_request->amount) }}</td>
                                                                <td>{{ $loan_request->purpose }}</td>
                                                                <td>
                                                                    @if ($loan_request->status == 'Pending')
                                                                        <span
                                                                            class="badge badge-light-warning">Pending</span>
                                                                    @elseif($loan_request->status == 'Approved')
                                                                        <span
                                                                            class="badge badge-light-success">Approved</span>
                                                                    @elseif($loan_request->status == 'Rejected')
                                                                        <span
                                                                            class="badge badge-light-danger">Rejected</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <small class="btn btn-primary btn-xs"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#guarantorsModal{{ $loan_request->id }}">
                                                                        View {{ $loan_request->guarantors->count() }}
                                                                        Guarantor(s)
                                                                    </small>

                                                                    <!-- Guarantors Modal -->
                                                                    <div class="modal fade"
                                                                        id="guarantorsModal{{ $loan_request->id }}"
                                                                        tabindex="-1"
                                                                        aria-labelledby="guarantorsModalLabel{{ $loan_request->id }}"
                                                                        aria-hidden="true">
                                                                        <div
                                                                            class="modal-dialog modal-lg modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="guarantorsModalLabel{{ $loan_request->id }}">
                                                                                        Loan Guarantors
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="guarantors-list">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Name</th>
                                                                                                        <th>Member No.</th>
                                                                                                        <th>Amount</th>
                                                                                                        <th>Status</th>
                                                                                                        <th>Decision Date
                                                                                                        </th>
                                                                                                        <th>Comments</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($loan_request->guarantors as $guarantor)
                                                                                                        <tr>
                                                                                                            <td>{{ $guarantor->first_name }}
                                                                                                                {{ $guarantor->last_name }}
                                                                                                            </td>
                                                                                                            <td>{{ $guarantor->membership_number }}
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="text-primary">
                                                                                                                UGX
                                                                                                                {{ number_format($guarantor->pivot->amount) }}
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <span
                                                                                                                    class="badge badge-light-{{ $guarantor->pivot->status == 'pending' ? 'warning' : ($guarantor->pivot->status == 'approved' ? 'success' : 'danger') }}">
                                                                                                                    {{ ucfirst($guarantor->pivot->status) }}
                                                                                                                </span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                @if ($guarantor->pivot->responded_at)
                                                                                                                    {{ date('d-m-Y', strtotime($guarantor->pivot->responded_at)) }}
                                                                                                                @else
                                                                                                                    -
                                                                                                                @endif
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                @if ($guarantor->pivot->response_comment)
                                                                                                                    <span
                                                                                                                        class="text-muted">{{ $guarantor->pivot->response_comment }}</span>
                                                                                                                @else
                                                                                                                    -
                                                                                                                @endif
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-light"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ date('d-m-Y', strtotime($loan_request->created_at)) }}
                                                                </td>
                                                                <td>
                                                                    <small class="btn btn-info btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#detailsModal{{ $loan_request->id }}">
                                                                        View Details
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Loan Request Panel --}}
                                    {{-- Start Loan Payment Panel --}}
                                    <div class="tab-pane fade" id="pills-loan_payments" role="tabpanel"
                                        aria-labelledby="pills-loan_payments-tab">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display basic-1" id="basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Loan Product</th>
                                                            <th>Amount Paid</th>
                                                            <th>Method</th>
                                                            <th class="text-center">Proof of Paymet</th>
                                                            <th>Notes</th>
                                                            <th>Date Added</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($loan_payments as $payment)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $payment->loanRequest->loanProduct->loan_type }}
                                                                </td>
                                                                <td class="text-success">UGX
                                                                    {{ number_format($payment->amount) }}</td>
                                                                <td>{{ $payment->payment_method }}</td>
                                                                <td class="text-center">
                                                                    @if (!empty($payment->receipt))
                                                                        <a href="#" class="open-modal"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal2"
                                                                            data-image="{{ asset($payment->receipt) }}">
                                                                            <img class="b-r-10"
                                                                                src="{{ asset($payment->receipt) }}"
                                                                                width="30px" height="40px">
                                                                        </a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>{{ $payment->narration ?? '-' }}</td>
                                                                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                                        <div class="modal fade" id="imageModal2" tabindex="-1"
                                                            aria-labelledby="imageModalLabel2" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Receipt Preview</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img id="modalImage2" src=""
                                                                            class="img-fluid b-r-10">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Loan Payment Panel --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- user profile fifth-style end-->

                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>

    <!-- Loan Details Modal -->
    @foreach ($loan_requests as $request)
        <div class="modal fade" id="detailsModal{{ $request->id }}" tabindex="-1"
            aria-labelledby="detailsModalLabel{{ $request->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title pb-2" id="detailsModalLabel{{ $request->id }}">
                            Loan Information
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Loan Details Section -->
                        <div class="loan-details mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Amount</small>
                                    <div class="fw-bold text-primary">UGX {{ number_format($request->amount) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Loan Type</small>
                                    <div>{{ $request->loanProduct->loan_type }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="txt-primary fw-bold">Purpose</small>
                                    <div>{{ $request->purpose }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Status</small>
                                    <div>
                                        <span
                                            class="badge badge-light-{{ $request->status == 'Pending' ? 'warning' : ($request->status == 'Approved' ? 'success' : 'danger') }}">
                                            {{ $request->status }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Loan History Section -->
                        <div class="loan-history">
                            <h6 class="border-bottom pb-2">Loan History</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction</th>
                                            <th>Comment</th>
                                            <th>Added By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($request->histories as $history)
                                            <tr>
                                                <td>{{ $history->created_at->format('M d, Y H:i') }}</td>
                                                <td>{{ $history->transaction_type }}</td>
                                                <td>{{ $history->comment }}</td>
                                                <td>{{ $history->addedBy->first_name . ' ' . $history->addedBy->last_name ?? 'System' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No history available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
