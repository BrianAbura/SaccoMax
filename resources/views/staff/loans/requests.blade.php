@extends('layouts/staff-main')
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
                            <li class="breadcrumb-item">
                                <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg>
                                </a>
                            </li>
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

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Loan Type</th>
                                            <th>Amount</th>
                                            <th>Purpose</th>
                                            <th>Guarantors Status</th>
                                            <th>Status</th>
                                            <th>Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loan_requests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="f-w-600 txt-primary">
                                                    {{ $request->member->first_name }}
                                                    {{ $request->member->last_name }}
                                                    <br>
                                                    <small class="text-muted">Member No:
                                                        {{ $request->member->membership_number }}</small>
                                                </td>
                                                <td>{{ $request->loanProduct->loan_type }}</td>
                                                <td class="text-primary">UGX
                                                    {{ number_format($request->amount) }}</td>
                                                <td>{{ $request->purpose }}</td>
                                                <td>
                                                    <div class="progress">
                                                        @php
                                                            $progress =
                                                                ($request->approved_guarantors /
                                                                    $request->total_guarantors) *
                                                                100;
                                                        @endphp
                                                        <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-warning' }}"
                                                            role="progressbar" style="width: {{ $progress }}%"
                                                            aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $request->approved_guarantors }}/{{ $request->total_guarantors }}
                                                        </div>
                                                    </div>
                                                    <small class="btn btn-primary btn-xs mt-2" data-bs-toggle="modal"
                                                        data-bs-target="#guarantorsModal{{ $request->id }}">
                                                        View {{ $request->guarantors->count() }} Guarantor(s)
                                                    </small>
                                                    <!-- Guarantors Modal -->
                                                    <div class="modal fade" id="guarantorsModal{{ $request->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="guarantorsModalLabel{{ $request->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="guarantorsModalLabel{{ $request->id }}">
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
                                                                                    @foreach ($request->guarantors as $guarantor)
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
                                                                                                    class="badge badge-xs badge-light-{{ $guarantor->pivot->status == 'pending' ? 'warning' : ($guarantor->pivot->status == 'approved' ? 'success' : 'danger') }}">
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
                                                <td>
                                                    <span
                                                        class="badge badge-light-{{ $request->status == 'Pending' ? 'warning' : ($request->status == 'Approved' ? 'success' : 'danger') }}">
                                                        {{ $request->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#detailsModal{{ $request->id }}">
                                                        View Details
                                                    </small>
                                                </td>
                                                <td>
                                                    @if ($request->status == 'Pending' && $request->approved_guarantors == $request->total_guarantors)
                                                        <button class="btn btn-success btn-xs mb-1" data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $request->id }}">
                                                            Approve
                                                        </button>
                                                        <button class="btn btn-danger btn-xs" data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $request->id }}">
                                                            Reject
                                                        </button>

                                                        <!-- Approve Modal -->
                                                        <div class="modal fade" id="approveModal{{ $request->id }}"
                                                            tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ route('staff.approve-loan-request', $request->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Approve Loan Request
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are you sure you want to approve this loan
                                                                                request?</p>
                                                                            {{-- <div class="col-10">
                                                                                <label class="form-label"
                                                                                    for="comments">Comments
                                                                                    (Optional)
                                                                                </label>
                                                                                <textarea class="form-control" id="comments" name="comments" placeholder="Add any comments about your approval"
                                                                                    rows="3">{{ old('comments') }}</textarea>
                                                                            </div> --}}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Confirm
                                                                                Approval</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Reject Modal -->
                                                        <div class="modal fade" id="rejectModal{{ $request->id }}"
                                                            tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ route('staff.reject-loan-request', $request->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Reject Loan Request
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3 col-md-10">
                                                                                <label class="form-label">Reason for
                                                                                    Rejection <span
                                                                                        class="text-danger">*</span></label>
                                                                                <textarea class="form-control" name="rejection_reason" required
                                                                                    placeholder="Please provide a reason for rejecting this loan request" rows="3">{{ old('rejection_reason') }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-warning">Confirm
                                                                                Rejection</button>
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
                                    <small class="txt-primary fw-bold">Member</small>
                                    <div class="fw-bold">{{ $request->member->first_name }}
                                        {{ $request->member->last_name }}</div>
                                    <div class="">Member No: {{ $request->member->membership_number }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Amount</small>
                                    <div class="fw-bold text-primary">UGX {{ number_format($request->amount) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="txt-primary fw-bold">Loan Type</small>
                                    <div>{{ $request->loanProduct->loan_type }}</div>
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
                                <div class="col-12">
                                    <small class="txt-primary fw-bold">Purpose</small>
                                    <div>{{ $request->purpose }}</div>
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
