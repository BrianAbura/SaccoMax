@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Shares</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                        <path
                                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Edit Shares </li>
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
                        <div class="card-body">
                            {{-- Alerts for the home page --}}
                            @if (session('success'))
                                <div class="alert alert-light-success alert-dismissible fade show col-md-4 mx-auto mb-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-light-secondary alert-dismissible fade show col-md-4 mx-auto mb-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('error') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}
                            <form class="row g-3" method="POST" action="{{ route('shares.update', $share->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Member</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="member_id">
                                            <option value="{{ $share->member->id }}">
                                                {{ $share->member->first_name . ' ' . $share->member->last_name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="number_of_shares">Number of Shares</label>
                                        <input class="form-control btn-pill commaAmount" id="number_of_shares"
                                            name="number_of_shares" type="text"
                                            placeholder="Number of Shares" aria-label="Number of Shares" required
                                            value="{{ $share->share_number }}">
                                        @error('number_of_shares')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="share_price">Share Price</label>
                                        <input class="form-control btn-pill commaAmount" id="share_price" name="share_price"
                                            type="text" placeholder="Share Price"
                                            aria-label="Share Price" required value="{{ number_format($share->share_amount) }}">
                                        @error('share_price')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Payment Date</label>
                                        <input class="form-control digits" type="date" name="payment_date"
                                            value="{{ $share->payment_date }}">
                                        @error('payment_date')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="shares_receipt">Proof of Payment</label>
                                        <input class="form-control btn-pill" id="shares_receipt" name="shares_receipt"
                                            type="file" value="{{ $share->receipt }}">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br><br>
                                        {{-- uploaded file --}}
                                        @if (!empty($share->receipt))
                                            <a href="#" class="open-modal" data-bs-toggle="modal"
                                                data-bs-target="#imageModal" data-image="{{ asset($share->receipt) }}">
                                                <img class="b-r-10" src="{{ asset($share->receipt) }}" width="60px">
                                            </a>
                                        @else
                                            <i class="icofont icofont-close-squared-alt h4" title="No file attached"></i>
                                        @endif
                                        {{-- end uploaded file --}}
                                        @error('shares_receipt')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update Record</button>
                                    <a href="{{ route('shares.show', $share->member->id) }}"
                                        class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap Modal (Single Modal for All Images) -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attachment Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid b-r-10">
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap Modal (Single Modal for All Images) -->
        <!-- Container-fluid Ends -->
    </div>
@endsection
