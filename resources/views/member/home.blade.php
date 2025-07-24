@extends('layouts/member-main')
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
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Progress border-b-warning border-2"> <span
                                        class="f-light f-w-500 f-14">Savings</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">UGX {{ number_format($total_savings) }}</h2>
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
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-project border-b-primary border-2"><span
                                        class="f-light f-w-500 f-14">Withdrawals</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">{{ number_format($total_withdrawals) }}</h2>
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
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Progress border-b-success border-2"> <span
                                        class="f-light f-w-500 f-14">Net Savings Balance</span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">UGX
                                                {{ number_format($total_savings - $total_withdrawals) }}</h2>
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
                {{-- second Row --}}
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Complete border-b-secondary border-2"><span
                                        class="f-light f-w-500 f-14">Total Amount Borrowed
                                    </span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">UGX {{ number_format($total_loan_requests) }}</h2>
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
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card o-hidden small-widget">
                                <div class="card-body total-Complete border-b-success border-2"><span
                                        class="f-light f-w-500 f-14">Total Loan Payments
                                    </span>
                                    <div class="project-details">
                                        <div class="project-counter">
                                            <h2 class="f-w-600">UGX {{ number_format($total_loan_payments) }}</h2>
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
                        </div>
                    </div>
                </div>
                {{-- Third Row --}}
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        @if ($guarantor_requests->count() > 0)
                            <div class="col-xl-4 col-sm-6">
                                <div class="card height-equal">
                                    <div class="card-header pb-0 total-revenue card-no-border">
                                        <h5 class="txt-info">Guarantor Requests </h5><a href="{{ route('member.guarantor-requests') }}">View
                                            All</a>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            @foreach ($guarantor_requests as $request)
                                                <li class="sale-history-card">
                                                    <div class="history-price"><a class="f-w-500 f-14  mb-0 txt-success" href="{{ route('member.guarantor-requests') }}">
                                                            {{ $request->loanRequest->member->first_name }}
                                                            {{ $request->loanRequest->member->last_name }}</a><span
                                                            class="mb-0 txt-primary f-w-600 f-14">UGX
                                                            {{ number_format($request->loanRequest->amount) }}</span></div>
                                                    <div class="state-time"> <span
                                                            class="f-w-500 f-14 f-light mb-0">{{ $request->loanRequest->loanProduct->loan_type }}</span><span
                                                            class="f-w-400 f-14 f-light">{{ date('d-m-Y', strtotime($request->created_at)) }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
