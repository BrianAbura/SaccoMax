@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Withdrawal</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                        <path
                                            d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                        <path
                                            d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Add Withdrawal </li>
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
                            <form class="row g-3" method="POST" action="{{ route('withdrawals.store') }}"
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
                                        <label class="form-label" for="amount-withdrawn">Amount</label>
                                        <input class="form-control btn-pill commaAmount" id="amount_withdrawn"
                                            name="amount_withdrawn" type="text" value="{{ old('amount_withdrawn') }}"
                                            placeholder="Amount Withdrawn" aria-label="Amount Withdrawn" required>
                                        @error('amount_withdrawn')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="withdrawal_narration">Withdrawal Narration</label>
                                        <textarea class="form-control btn-pill" id="withdrawal_narration" name="withdrawal_narration"
                                            placeholder="Withdrawal Narration" rows="2" required>{{ old('withdrawal_narration') }}</textarea>
                                        @error('withdrawal_narration')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Withdrawal Date</label>
                                        <input class="form-control digits btn-pill" type="date" name="withdrawal_date">
                                        @error('withdrawal_date')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="amount-withdrawn">Charges</label>
                                        <input class="form-control btn-pill commaAmount" id="charges"
                                            name="charges" type="text" value="{{ old('charges') }}"
                                            placeholder="Charges" aria-label="Charges" required>
                                        @error('charges')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
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
