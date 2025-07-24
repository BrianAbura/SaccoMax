@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Dashboard </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                        <a href="{{ route('members.index') }}">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-success border-2"><span
                                        class="f-light f-w-500 f-14">Total Members</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ number_format($total_members) }}</h2>
                                        </div>
                                        <div class="product-sub bg-success-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                        <a href="{{ route('savings.index') }}">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Progress border-b-warning border-2"> <span
                                        class="f-light f-w-500 f-14">Gross Savings Balance</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h3 class="f-w-600">UGX {{ number_format($total_savings) }}</h3>
                                        </div>
                                        <div class="product-sub bg-warning-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                                <path
                                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                                <path
                                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                        <a href="{{ route('withdrawals.index') }}">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-primary border-2"><span
                                        class="f-light f-w-500 f-14">Total Withdrawals</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">UGX {{ number_format($total_withdrawals) }}</h2>
                                        </div>
                                        <div class="product-sub bg-primary-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                                <path
                                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                                <path
                                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                    </ul>
                                    <span class="f-12 f-w-400">(Charges Inclusive)</span>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Progress border-b-success border-2"> <span
                                        class="f-light f-w-500 f-14">Net Savings Balance</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h3 class="f-w-600">UGX
                                                {{ number_format($total_savings - $total_withdrawals) }}</h3>
                                        </div>
                                        <div class="product-sub bg-success-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                                <path
                                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                                <path
                                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                            </svg>
                                        </div>

                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                    </ul>
                                    <span class="f-12 f-w-400">(After Withdrawals)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Second Row --}}
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                        <a href="{{ route('staff.loan-requests') }}">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Complete border-b-secondary border-2"><span
                                        class="f-light f-w-500 f-14">Total Loans Disbursed</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h3 class="f-w-600">UGX {{ number_format($loan_requests) }}</h3>
                                        </div>
                                        <div class="product-sub bg-secondary-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                                                <path
                                                    d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"> </li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"> </li>
                                        <li class="bubble"></li>
                                        <li class="bubble"> </li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"> </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                        <a href="{{ route('staff.loan-payments.index') }}">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-upcoming"><span class="f-light f-w-500 f-14">Total Loan
                                        Payments</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h3 class="f-w-600">UGX {{ number_format($loan_payments) }}</h3>
                                        </div>
                                        <div class="product-sub bg-success-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="currentColor" class="bi bi-bookmark-check-fill"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="bubbles">
                                        <li class="bubble"> </li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                        <li class="bubble"></li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
