@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Annual Fee</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-piggy-bank" viewBox="0 0 16 16">
                                        <path
                                            d="M5 6.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0m1.138-1.496A6.6 6.6 0 0 1 7.964 4.5c.666 0 1.303.097 1.893.273a.5.5 0 0 0 .286-.958A7.6 7.6 0 0 0 7.964 3.5c-.734 0-1.441.103-2.102.292a.5.5 0 1 0 .276.962" />
                                        <path fill-rule="evenodd"
                                            d="M7.964 1.527c-2.977 0-5.571 1.704-6.32 4.125h-.55A1 1 0 0 0 .11 6.824l.254 1.46a1.5 1.5 0 0 0 1.478 1.243h.263c.3.513.688.978 1.145 1.382l-.729 2.477a.5.5 0 0 0 .48.641h2a.5.5 0 0 0 .471-.332l.482-1.351c.635.173 1.31.267 2.011.267.707 0 1.388-.095 2.028-.272l.543 1.372a.5.5 0 0 0 .465.316h2a.5.5 0 0 0 .478-.645l-.761-2.506C13.81 9.895 14.5 8.559 14.5 7.069q0-.218-.02-.431c.261-.11.508-.266.705-.444.315.306.815.306.815-.417 0 .223-.5.223-.461-.026a1 1 0 0 0 .09-.255.7.7 0 0 0-.202-.645.58.58 0 0 0-.707-.098.74.74 0 0 0-.375.562c-.024.243.082.48.32.654a2 2 0 0 1-.259.153c-.534-2.664-3.284-4.595-6.442-4.595M2.516 6.26c.455-2.066 2.667-3.733 5.448-3.733 3.146 0 5.536 2.114 5.536 4.542 0 1.254-.624 2.41-1.67 3.248a.5.5 0 0 0-.165.535l.66 2.175h-.985l-.59-1.487a.5.5 0 0 0-.629-.288c-.661.23-1.39.359-2.157.359a6.6 6.6 0 0 1-2.157-.359.5.5 0 0 0-.635.304l-.525 1.471h-.979l.633-2.15a.5.5 0 0 0-.17-.534 4.65 4.65 0 0 1-1.284-1.541.5.5 0 0 0-.446-.275h-.56a.5.5 0 0 1-.492-.414l-.254-1.46h.933a.5.5 0 0 0 .488-.393m12.621-.857a.6.6 0 0 1-.098.21l-.044-.025c-.146-.09-.157-.175-.152-.223a.24.24 0 0 1 .117-.173c.049-.027.08-.021.113.012a.2.2 0 0 1 .064.199" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Edit Annual Fee </li>
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
                            <form class="row g-3" method="POST" action="{{ route('annual-fees.update', $annualfee->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="member_id">Member</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="member_id">
                                            <option value="{{ $annualfee->member->id }}">
                                                {{ $annualfee->member->first_name . ' ' . $annualfee->member->last_name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="annual_fee">Annual Fee</label>
                                        <input class="form-control btn-pill commaAmount" id="annual_fee" name="annual_fee"
                                            type="text" placeholder="Annual Fee" aria-label="Annual Fee" required
                                            value="{{ number_format($annualfee->amount) }}">
                                        @error('annual_fee')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="fee_year">Annual Fee For (Year)</label>
                                        <input class="form-control btn-pill" id="fee_year" name="fee_year"
                                            type="text" value="{{ $annualfee->year }}" placeholder="Fee Year: e.g. 2025"
                                            aria-label="Fee Year" required>
                                        @error('fee_year')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Payment Date</label>
                                        <input class="form-control digits" type="date" name="payment_date"
                                            value="{{ $annualfee->payment_date }}">
                                        @error('payment_date')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="annual_fee_receipt">Proof of Payment</label>
                                        <input class="form-control btn-pill" id="annual_fee_receipt"
                                            name="annual_fee_receipt" type="file" value="{{ $annualfee->receipt }}">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br><br>
                                        {{-- uploaded file --}}
                                        @if (!empty($annualfee->receipt))
                                            <a href="#" class="open-modal" data-bs-toggle="modal"
                                                data-bs-target="#imageModal" data-image="{{ asset($annualfee->receipt) }}">
                                                <img class="b-r-10" src="{{ asset($annualfee->receipt) }}" width="60px">
                                            </a>
                                        @else
                                            <i class="icofont icofont-close-squared-alt h4" title="No file attached"></i>
                                        @endif
                                        {{-- end uploaded file --}}
                                        @error('annual_fee_receipt')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update Record</button>
                                    <a href="{{ route('annual-fees.show', $annualfee->member->id) }}"
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
