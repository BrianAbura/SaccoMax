@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Loan Product</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-tools" viewBox="0 0 16 16">
                                        <path
                                            d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Edit Loan Product </li>
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
                            <form class="row g-3" method="POST" action="{{ route('loan-product.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="amount-saved">Loan Type</label>
                                        <textarea class="form-control btn-pill" id="loan_type" name="loan_type" rows="2" required>{{ $product->loan_type }}</textarea>

                                        @error('loan_type')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="amount-saved">Maximum Loan Amount</label>
                                        <input class="form-control btn-pill commaAmount" id="max_loan_amount"
                                            name="max_loan_amount" type="text"
                                            value="{{ number_format($product->max_loan_amount) }}" required>
                                        @error('max_loan_amount')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Loan Period (Months)</label>
                                        <input class="form-control btn-pill commaAmount" id="loan_period" name="loan_period"
                                            type="number" max="100" value="{{ $product->loan_period }}" required>
                                        @error('loan_period')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Annual Interest Rate</label>
                                        <input class="form-control btn-pill commaAmount" id="annual_interest_rate"
                                            name="annual_interest_rate" type="text"
                                            value="{{ $product->annual_interest_rate }}" required>
                                        @error('annual_interest_rate')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Monthly Interest Rate</label>
                                        <input class="form-control btn-pill" id="monthly_interest_rate"
                                            name="monthly_interest_rate" type="text"
                                            value="{{ $product->monthly_interest_rate }}" readonly>
                                        @error('monthly_interest_rate')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Grace Period (Days)</label>
                                        <input class="form-control btn-pill commaAmount" id="grace_period" name="grace_period"
                                            type="number" value="{{ $product->grace_period }}">
                                        @error('grace_period')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="validationDefault04">Payment Frequency</label>
                                        <select class="form-select btn-pill" id="validationDefault04"
                                            name="payment_frequency" required>
                                            <option value="Daily"
                                                {{ $product->payment_frequency == 'Daily' ? 'selected' : '' }}>Daily
                                            </option>
                                            <option value="Weekly"
                                                {{ $product->payment_frequency == 'Weekly' ? 'selected' : '' }}>Weekly
                                            </option>
                                            <option value="Monthly"
                                                {{ $product->payment_frequency == 'Monthly' ? 'selected' : '' }}>Monthly
                                            </option>
                                            <option value="Quarterly"
                                                {{ $product->payment_frequency == 'Quarterly' ? 'selected' : '' }}>
                                                Quarterly</option>
                                            <option value="Annually"
                                                {{ $product->payment_frequency == 'Annually' ? 'selected' : '' }}>Annually
                                            </option>
                                        </select>
                                        @error('grace_period')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
