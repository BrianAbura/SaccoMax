@extends('layouts/member-main')
@section('title', 'UPP SACCO - Loan Application')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('member.home') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg></a>
                            </li>
                            <li class="breadcrumb-item">Loan Application</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Loan Application Form</h5>
                            <span class="text-danger">Please fill in all the required information</span>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="needs-validation" method="POST" action="{{ route('member.store-loan-request') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="loan_product_id">Loan Product <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select btn-pill" id="loan_product_id" name="loan_product_id"
                                            required>
                                            <option value="">Select Loan Product</option>
                                            @foreach ($loanProducts as $product)
                                                <option value="{{ $product->id }}"
                                                    data-annual="{{ $product->annual_interest_rate }}"
                                                    data-monthly="{{ $product->monthly_interest_rate }}"
                                                    data-term="{{ $product->loan_period }}"
                                                    data-max="{{ $product->max_loan_amount }}">
                                                    {{ $product->loan_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="loan_details" class="mt-3 fw-bold" style="display: none; color: teal;">
                                            <p class="mb-1">Maximum Loan Amount: <span id="max_loan_amount">-</span></p>
                                            <p class="mb-1">Annual Interest Rate: <span id="interest_rate">-</span>%</p>
                                            <p class="mb-1">Loan Period: <span id="loan_period">-</span> months</p>
                                        </div>
                                        <div id="saving_details" class="mt-3 fw-bold"
                                            style="display: none; color: midnightblue;">
                                            <p class="mb-1">
                                                Current Savings Balance:
                                                <span>UGX {{ number_format(Auth::user()->net_savings_balance()) }}</span>

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="amount">
                                            Loan Amount (UGX) <span class="text-danger">*</span>
                                            <span class="badge badge-primary rounded-pill" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="The loan amount should not exceed the maximum loan amount for the selected product"><i
                                                    class="fa fa-info"></i></span>
                                        </label>
                                        <input type="text" class="form-control btn-pill commaAmount" id="amount"
                                            name="amount" required>
                                        <div class="invalid-feedback">Please enter the loan amount.</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="purpose">Purpose of Loan <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control btn-pill" id="purpose" name="purpose" rows="3" required></textarea>
                                        <div class="invalid-feedback">Please provide the purpose of the loan.</div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="mt-4 mb-4">
                                        <h5 class="mb-3">Guarantors Information
                                            <span class="badge badge-primary rounded-pill" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="The amount guaranteed by each guarantor should not exceed the loan amount."><i
                                                    class="fa fa-info"></i></span>
                                        </h5>
                                        <div id="guarantors_section">
                                            <div class="row g-3 guarantor-entry mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        Select Guarantor
                                                    </label>
                                                    <select class="form-select guarantor-select" name="guarantors[]"
                                                        required>
                                                        <option value="">Choose a guarantor...</option>
                                                        @foreach ($members as $member)
                                                            <option value="{{ $member->id }}">
                                                                {{ $member->first_name }} {{ $member->last_name }}
                                                                ({{ $member->membership_number }})
                                                                - Maximum Gurantee Amount: UGX
                                                                {{ number_format($member->guarantor_max_limit()) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label">
                                                        Amount to Guarantee (UGX)
                                                    </label>
                                                    <input type="text"
                                                        class="form-control btn-pill commaAmount guarantee-amount"
                                                        name="guarantee_amounts[]" required>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button"
                                                        class="btn btn-danger btn-pill btn-sm remove-guarantor"
                                                        style="display: none;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info btn-pill" id="add_guarantor">
                                            <i class="fa fa-plus"></i> Add Another Guarantor
                                        </button>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <span class="text-danger"><strong>Note</strong>: Combined guarantor amounts plus
                                            your current savings balance must cover the loan amount.</span>
                                        <br><br>
                                        <button class="btn btn-success btn-pill" type="submit">Submit Loan
                                            Application</button>
                                        <a href="{{ route('member.loan_requests') }}"
                                            class="btn btn-danger btn-pill">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips when adding new guarantor fields
            document.getElementById('add_guarantor').addEventListener('click', function() {
                setTimeout(function() {
                    var newTooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    newTooltips.forEach(function(element) {
                        new bootstrap.Tooltip(element);
                    });
                }, 100);
            });
        });
    </script>
@endpush
