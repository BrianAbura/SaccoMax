@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Loan Payment Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('staff.loan-payments.index') }}">Loan Payments</a>
                            </li>
                            <li class="breadcrumb-item">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Loan Details Card -->
                <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-top">
                                <h5 class="m-0">Loan Information</h5>
                                <div class="card-header-right-icon">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addPaymentModal">
                                        Add Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Member</small>
                                    <div class="fw-bold">{{ $loan->member->first_name }} {{ $loan->member->last_name }}
                                    </div>
                                    <div class="text-muted">Member No: {{ $loan->member->membership_number }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Loan Type</small>
                                    <div>{{ $loan->loanProduct->loan_type }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="txt-primary fw-bold">Loan Amount</small>
                                    <div class="fw-bold text-primary">UGX {{ number_format($loan->amount) }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="txt-primary fw-bold">Total Paid</small>
                                    <div class="fw-bold text-success">UGX {{ number_format($total_paid) }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="txt-primary fw-bold">Balance</small>
                                    <div class="fw-bold text-danger">UGX {{ number_format($loan->amount - $total_paid) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments History Card -->
                <div class="col-sm-12">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-header">
                            <h5>Payment History</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th class="text-center">Proof of Paymet</th>
                                            <th>Notes</th>
                                            <th>Recorded By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                                <td class="text-success">UGX {{ number_format($payment->amount) }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td class="text-center">
                                                    @if (!empty($payment->receipt))
                                                        <a href="#" class="open-modal" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-image="{{ asset($payment->receipt) }}">
                                                            <img class="b-r-10" src="{{ asset($payment->receipt) }}"
                                                                width="30px" height="40px">
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $payment->narration ?? '-' }}</td>
                                                <td>{{ $payment->recordedBy->first_name }}
                                                    {{ $payment->recordedBy->last_name }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#editPaymentModal{{ $payment->id }}"><i
                                                                    class="icon-pencil-alt"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Edit Payment Modal -->
                                            <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1"
                                                aria-labelledby="editPaymentModalLabel{{ $payment->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Payment</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('staff.loan-payments.update', $payment->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Amount</label>
                                                                    <input type="text" class="form-control commaAmount"
                                                                        name="amount"
                                                                        value="{{ number_format($payment->amount) }}"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Payment Method</label>
                                                                    <select class="form-select" name="payment_method"
                                                                        required>
                                                                        <option value="Cash"
                                                                            {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>
                                                                            Cash</option>
                                                                        <option value="Bank Transfer"
                                                                            {{ $payment->payment_method == 'Bank Transfer' ? 'selected' : '' }}>
                                                                            Bank Transfer</option>
                                                                        <option value="Mobile Money"
                                                                            {{ $payment->payment_method == 'Mobile Money' ? 'selected' : '' }}>
                                                                            Mobile Money</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Payment Receipt</label>
                                                                    <input type="file" class="form-control"
                                                                        name="payment_receipt">
                                                                    @if ($payment->receipt)
                                                                        <small class="text-muted">Current receipt:
                                                                            {{ basename($payment->receipt) }}</small>
                                                                    @endif
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Notes</label>
                                                                    <textarea class="form-control" name="notes" rows="3">{{ $payment->narration }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update
                                                                    Payment</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                        <div class="modal fade" id="imageModal" tabindex="-1"
                                            aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Receipt Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img id="modalImage" src="" class="img-fluid b-r-10">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Record Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('staff.loan-payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="loan_request_id" value="{{ $loan->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control commaAmount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select" name="payment_method" required>
                                <option value="">Select Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Mobile Money">Mobile Money</option>
                                <option value="Check">Check</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Receipt</label>
                            <input class="form-control btn-pill" id="payment_receipt" name="payment_receipt"
                                type="file" required>
                            <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br>
                            @error('payment_receipt')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
