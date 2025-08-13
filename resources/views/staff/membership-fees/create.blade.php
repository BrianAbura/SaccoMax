@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Membership Fee</h4>
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
                            <li class="breadcrumb-item">Add Membership </li>
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
                            <form class="row g-3" method="POST" action="{{ route('fees-membership.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Member</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="member_id"
                                            required>
                                            <option selected="" disabled="" value="">Choose...</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">
                                                    {{ $member->first_name . ' ' . $member->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="membership_fee">Membership Fee</label>
                                        <input class="form-control btn-pill commaAmount" id="membership_fee"
                                            name="membership_fee" type="text" value="{{ old('membership_fee') }}"
                                            placeholder="Membership Fee" aria-label="Membership Fee" required>
                                        @error('membership_fee')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Payment Date</label>
                                        <input class="form-control digits" type="date" name="payment_date">
                                        @error('payment_date')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="membership_fee_receipt">Proof of Payment</label>
                                        <input class="form-control btn-pill" id="membership_fee_receipt" name="membership_fee_receipt"
                                            type="file" required>
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br>
                                        @error('membership_fee_receipt')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Add Record</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
