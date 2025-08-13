@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Shares</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                    <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z"/>
                                  </svg></a></li>
                            <li class="breadcrumb-item">Shares </li>
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

                            <a href="{{ route('shares.create') }}" class="btn btn-primary m-3">Add Shares</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Membership Number</th>
                                            <th>Fullname</th>
                                            <th>Total Share Amount</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shares as $share)
                                            <tr>
                                                <td class="text-primary text-center"><a class="text-primary "
                                                        href="{{ route('members.show', $share->member->id) }}">{{ $share->member->membership_number }}</a>
                                                </td>
                                                <td class="h6 text-primary">
                                                    <a class="text-primary "
                                                        href="{{ route('members.show', $share->member->id) }}">{{ $share->member->first_name . ' ' . $share->member->last_name }}</a>
                                                </td>
                                                <td class="f-w-600 txt-success">UGX
                                                    {{ number_format($share->total_amount) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('shares.show', $share->member->id) }}"
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
