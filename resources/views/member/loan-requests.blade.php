@extends('layouts/member-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Loan Requests</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Loan Requests</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="d-flex justify-content-end align-items-center">
                            {{-- Alerts for the home page --}}
                            @if (session('success'))
                                <div class="alert alert-light-success alert-dismissible fade show mx-auto col-md-4 m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-light-danger alert-dismissible fade show mx-auto col-md-4 m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('error') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}
                            <a href="{{ route('member.request-loan') }}" class="btn btn-primary m-3">Request For A Loan</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Loan Product</th>
                                            <th>Amount</th>
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
                                                <td class="text-primary">UGX {{ number_format($loan_request->amount) }}</td>
                                                <td>{{ $loan_request->purpose }}</td>
                                                <td>
                                                    @if ($loan_request->status == 'Pending')
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    @elseif($loan_request->status == 'Approved')
                                                        <span class="badge badge-light-success">Approved</span>
                                                    @elseif($loan_request->status == 'Rejected')
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="progress mb-2">
                                                        @php
                                                            $progress =
                                                                ($loan_request->approved_guarantors /
                                                                    $loan_request->total_guarantors) *
                                                                100;
                                                        @endphp
                                                        <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-warning' }}"
                                                            role="progressbar" style="width: {{ $progress }}%"
                                                            aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $loan_request->approved_guarantors }}/{{ $loan_request->total_guarantors }}
                                                        </div>
                                                    </div>
                                                    <small class="btn btn-primary btn-xs" data-bs-toggle="modal"
                                                        data-bs-target="#guarantorsModal{{ $loan_request->id }}">
                                                        View {{ $loan_request->guarantors->count() }} Guarantor(s)
                                                    </small>

                                                    <!-- Guarantors Modal -->
                                                    <div class="modal fade" id="guarantorsModal{{ $loan_request->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="guarantorsModalLabel{{ $loan_request->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="guarantorsModalLabel{{ $loan_request->id }}">
                                                                        Loan Guarantors
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                                        <th>Decision Date</th>
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
                                                                                            <td class="text-primary">UGX
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
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($loan_request->created_at)) }}</td>
                                                <td>
                                                    @if ($loan_request->status == 'Pending')
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#cancelModal{{ $loan_request->id }}">
                                                            Cancel Request
                                                        </button>

                                                        <!-- Cancel Modal -->
                                                        <div class="modal fade" id="cancelModal{{ $loan_request->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="cancelModalLabel{{ $loan_request->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="cancelModalLabel{{ $loan_request->id }}">
                                                                            Cancel Loan Request
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="badge badge-success">
                                                                            <h6>Are you sure you want to cancel this loan
                                                                                request?</h6>
                                                                            <p class="mb-0">
                                                                                <strong>Loan Amount:</strong> UGX
                                                                                {{ number_format($loan_request->amount) }}<br>
                                                                                <strong>Purpose:</strong>
                                                                                {{ $loan_request->purpose }}<br>
                                                                                <strong>Product:</strong>
                                                                                {{ $loan_request->loanProduct->loan_type }}
                                                                            </p>
                                                                        </div>
                                                                        <p class="text-danger mb-0">
                                                                            <i class="fa fa-info-circle"></i>
                                                                            This action cannot be undone. All guarantor
                                                                            associations will be removed.
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a href="{{ route('member.cancel-loan-request', $loan_request->id) }}"
                                                                            class="btn btn-danger">
                                                                            Confirm Cancellation
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($loan_request->status == 'Rejected')
                                                        <div class="btn-group">
                                                            <a href="{{ route('member.edit-loan-request', $loan_request->id) }}"
                                                                class="btn btn-primary btn-sm me-2">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#resubmitModal{{ $loan_request->id }}">
                                                                <i class="fa fa-refresh"></i> Resubmit
                                                            </button>
                                                        </div>

                                                        <!-- Resubmit Modal -->
                                                        <div class="modal fade" id="resubmitModal{{ $loan_request->id }}"
                                                            tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ route('member.resubmit-loan-request', $loan_request->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Resubmit Loan Request
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are you sure you want to resubmit this loan
                                                                                request? Your guarantors will need to
                                                                                approve again.</p>
                                                                            <div class="txt-danger">
                                                                                <strong>Rejection Reason:</strong>
                                                                                {{ $loan_request->rejection_reason }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Resubmit
                                                                                Request</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
