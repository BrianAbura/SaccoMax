@extends('layouts/member-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Guarantor Requests</h4>
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
                            <li class="breadcrumb-item">Guarantor Requests</li>
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
                                            <th>Borrower</th>
                                            <th>Loan Type</th>
                                            <th>Loan Amount</th>
                                            <th>Guaranteed Amount</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Decision Date</th>
                                            <th>Comment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guarantor_requests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="f-w-600 txt-primary">
                                                    {{ $request->loanRequest->member->first_name }}
                                                    {{ $request->loanRequest->member->last_name }}
                                                    <br>
                                                    <small class="text-muted">Member No:
                                                        {{ $request->loanRequest->member->membership_number }}</small>
                                                </td>
                                                <td>{{ $request->loanRequest->loanProduct->loan_type }}</td>
                                                <td class="text-primary">UGX
                                                    {{ number_format($request->loanRequest->amount) }}</td>
                                                <td class="txt-primary">UGX {{ number_format($request->amount) }}</td>
                                                <td>{{ $request->loanRequest->purpose }}</td>

                                                <td>
                                                    <span
                                                        class="badge badge-light-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'approved' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($request->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($request->responded_at)
                                                        {{ date('d-m-Y', strtotime($request->responded_at)) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($request->response_comment)
                                                        <span class="text-muted">{{ $request->response_comment }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($request->status == 'pending')
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
                                                                        action="{{ route('member.approve-guarantor-request', $request->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Approve Guarantor
                                                                                Request</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="col-10">
                                                                                <label class="form-label"
                                                                                    for="comments">Comments
                                                                                    (Optional)
                                                                                </label>
                                                                                <textarea class="form-control" id="comments" name="comments" placeholder="Add any comments about your approval"
                                                                                    rows="3">{{ old('comments') }}</textarea>
                                                                            </div>

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
                                                                        action="{{ route('member.reject-guarantor-request', $request->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Reject Guarantor Request
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
                                                                                <textarea class="form-control" name="comments" rows="3" required
                                                                                    placeholder="Please provide a reason for rejecting this request"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Confirm
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
        <!-- Container-fluid Ends-->
    </div>
@endsection
