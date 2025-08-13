@extends('layouts/member-main')
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                        <path
                                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z" />
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
                        {{-- <div class="card-header">
                            <h5 class="m-b-0 txt-primary">Summary:
                                <strong>{{ $member->first_name . ' ' . $member->last_name }} -
                                    {{ $member->membership_number }}</strong>
                                <a href="{{ route('savings.index') }}"><i
                                        class="fa fa-reply d-flex justify-content-end h6"></i></a>
                            </h5>
                        </div> --}}
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Number of Shares</th>
                                            <th>Share Price</th>
                                            <th>Shareholding Value</th>
                                            <th>Payment Date</th>
                                            <th class="text-center">Proof of Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shares as $share)
                                            @php
                                                $cnt = $loop->iteration;
                                            @endphp
                                            <tr>
                                                <td>{{ $cnt }}</td>
                                                <td class="text-center">{{ number_format($share->share_number) }}</td>
                                                <td class="text-primary">UGX {{ number_format($share->share_amount) }}</td>
                                                <td class="text-success">UGX
                                                    {{ number_format($share->share_number * $share->share_amount) }}</td>
                                                <td> {{ date('d-m-Y', strtotime($share->payment_date)) }} </td>
                                                <td class="text-center">
                                                    @if (!empty($share->receipt))
                                                        <a href="#" class="open-modal" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-image="{{ asset($share->receipt) }}">
                                                            <img class="b-r-10" src="{{ asset($share->receipt) }}"
                                                                width="60px">
                                                        </a>
                                                    @else
                                                        -
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
                                                        <h5 class="modal-title">Attachment Preview</h5>
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
        <!-- Container-fluid Ends -->
    </div>
@endsection
