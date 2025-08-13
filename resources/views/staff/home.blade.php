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
                                    <div class="card-body total-upcoming border-b-success border-2"><span
                                            class="f-light f-w-500 f-14">Total Loan
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
                            <a href="{{ route('shares.index') }}">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming border-b-warning border-2"><span
                                            class="f-light f-w-500 f-14">Total Share
                                            Value</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h3 class="f-w-600">UGX {{ number_format($shares->total_share_value) }}
                                                </h3>
                                            </div>
                                            <div class="product-sub bg-warning-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z" />
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
                                        <span class="f-12 f-w-600">{{ number_format($shares->total_number_of_shares) }}
                                            shares purchased</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <a href="{{ route('fees-membership.index') }}">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming border-b-primary border-2"><span
                                            class="f-light f-w-500 f-14">Total Membership Fees</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h3 class="f-w-600">UGX {{ number_format($membership_fees) }}</h3>
                                            </div>
                                            <div class="product-sub bg-primary-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                                    <path
                                                        d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                                    <path
                                                        d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
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
                    </div>
                </div>
                {{-- Third Row --}}
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <a href="{{ route('annual-fees.index') }}">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming border-b-warning border-2"><span
                                            class="f-light f-w-500 f-14">Total Annual Fees</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h3 class="f-w-600">UGX {{ number_format($annual_fees) }}</h3>
                                            </div>
                                            <div class="product-sub bg-warning-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-piggy-bank" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5 6.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0m1.138-1.496A6.6 6.6 0 0 1 7.964 4.5c.666 0 1.303.097 1.893.273a.5.5 0 0 0 .286-.958A7.6 7.6 0 0 0 7.964 3.5c-.734 0-1.441.103-2.102.292a.5.5 0 1 0 .276.962" />
                                                    <path fill-rule="evenodd"
                                                        d="M7.964 1.527c-2.977 0-5.571 1.704-6.32 4.125h-.55A1 1 0 0 0 .11 6.824l.254 1.46a1.5 1.5 0 0 0 1.478 1.243h.263c.3.513.688.978 1.145 1.382l-.729 2.477a.5.5 0 0 0 .48.641h2a.5.5 0 0 0 .471-.332l.482-1.351c.635.173 1.31.267 2.011.267.707 0 1.388-.095 2.028-.272l.543 1.372a.5.5 0 0 0 .465.316h2a.5.5 0 0 0 .478-.645l-.761-2.506C13.81 9.895 14.5 8.559 14.5 7.069q0-.218-.02-.431c.261-.11.508-.266.705-.444.315.306.815.306.815-.417 0 .223-.5.223-.461-.026a1 1 0 0 0 .09-.255.7.7 0 0 0-.202-.645.58.58 0 0 0-.707-.098.74.74 0 0 0-.375.562c-.024.243.082.48.32.654a2 2 0 0 1-.259.153c-.534-2.664-3.284-4.595-6.442-4.595M2.516 6.26c.455-2.066 2.667-3.733 5.448-3.733 3.146 0 5.536 2.114 5.536 4.542 0 1.254-.624 2.41-1.67 3.248a.5.5 0 0 0-.165.535l.66 2.175h-.985l-.59-1.487a.5.5 0 0 0-.629-.288c-.661.23-1.39.359-2.157.359a6.6 6.6 0 0 1-2.157-.359.5.5 0 0 0-.635.304l-.525 1.471h-.979l.633-2.15a.5.5 0 0 0-.17-.534 4.65 4.65 0 0 1-1.284-1.541.5.5 0 0 0-.446-.275h-.56a.5.5 0 0 1-.492-.414l-.254-1.46h.933a.5.5 0 0 0 .488-.393m12.621-.857a.6.6 0 0 1-.098.21l-.044-.025c-.146-.09-.157-.175-.152-.223a.24.24 0 0 1 .117-.173c.049-.027.08-.021.113.012a.2.2 0 0 1 .064.199" />
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
                            <a href="{{ route('incomes.index') }}">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming border-b-success border-2"><span
                                            class="f-light f-w-500 f-14">Total Income Received</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h3 class="f-w-600">UGX {{ number_format($incomes) }}</h3>
                                            </div>
                                            <div class="product-sub bg-success-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
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
                            <a href="{{ route('incomes.index') }}">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming border-b-danger border-2"><span
                                            class="f-light f-w-500 f-14">Total Expenses Incurred</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h3 class="f-w-600">UGX {{ number_format($expenses) }}</h3>
                                            </div>
                                            <div class="product-sub bg-danger-light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-graph-down-arrow"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
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
                    </div>
                </div>
            </div>

        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
