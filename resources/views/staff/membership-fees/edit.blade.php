@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Membership Fee</h4>
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
                            <li class="breadcrumb-item">Edit Membership Fee </li>
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
                            <form class="row g-3" method="POST" action="{{ route('fees-membership.update', $membershipfee->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Member</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="member_id">
                                            <option value="{{ $membershipfee->member->id }}">
                                                {{ $membershipfee->member->first_name . ' ' . $membershipfee->member->last_name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="membership_fee">Membership Fee</label>
                                        <input class="form-control btn-pill commaAmount" id="membership_fee"
                                            name="membership_fee" type="text" placeholder="Membership Fee"
                                            aria-label="Membership Fee" required value="{{ number_format($membershipfee->amount) }}">
                                        @error('membership_fee')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Payment Date</label>
                                        <input class="form-control digits" type="date" name="payment_date"
                                            value="{{ $membershipfee->payment_date }}">
                                        @error('payment_date')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="membership_fee_receipt">Proof of Payment</label>
                                        <input class="form-control btn-pill" id="membership_fee_receipt" name="membership_fee_receipt"
                                            type="file" value="{{ $membershipfee->receipt }}">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br><br>
                                        {{-- uploaded file --}}
                                        @if (!empty($membershipfee->receipt))
                                            <a href="#" class="open-modal" data-bs-toggle="modal"
                                                data-bs-target="#imageModal" data-image="{{ asset($membershipfee->receipt) }}">
                                                <img class="b-r-10" src="{{ asset($membershipfee->receipt) }}" width="60px">
                                            </a>
                                        @else
                                            <i class="icofont icofont-close-squared-alt h4" title="No file attached"></i>
                                        @endif
                                        {{-- end uploaded file --}}
                                        @error('membership_fee_receipt')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update Record</button>
                                    <a href="{{ route('fees-membership.show', $membershipfee->member->id) }}"
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
