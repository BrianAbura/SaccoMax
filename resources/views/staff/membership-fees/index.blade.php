@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Membership Fees</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-cash-stack" viewBox="0 0 16 16">
                                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                        <path
                                            d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Membership Fees </li>
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
                                <div class="alert alert-light-success alert-dismissible fade show mx-auto col-md-4 m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}

                            <a href="{{ route('fees-membership.create') }}" class="btn btn-primary m-3">Add Membership
                                Fee</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Membership Number</th>
                                            <th>Fullname</th>
                                            <th>Membership Fee</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($membershipfees as $membershipfee)
                                            <tr>
                                                <td class="text-primary text-center"><a class="text-primary "
                                                        href="{{ route('members.show', $membershipfee->member->id) }}">{{ $membershipfee->member->membership_number }}</a>
                                                </td>
                                                <td class="h6 text-primary">
                                                    <a class="text-primary "
                                                        href="{{ route('members.show', $membershipfee->member->id) }}">{{ $membershipfee->member->first_name . ' ' . $membershipfee->member->last_name }}</a>
                                                </td>
                                                <td class="f-w-600 txt-success">UGX
                                                    {{ number_format($membershipfee->total_amount) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('fees-membership.show', $membershipfee->member->id) }}"
                                                        class="btn btn-sm btn-info">View Details</a>
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
