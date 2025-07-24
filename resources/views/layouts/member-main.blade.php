<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SaccoMax – Smart, secure SACCO management software to digitize operations, manage savings & loans, and empower your cooperative’s future.">
    <meta name="keywords" content="SACCO software, cooperative management system, SaccoMax, digital SACCO platform, savings and credit software, cooperative solutions, SACCO ERP, loan management system">

    <link rel="icon" href="{{ asset('assets/images/logo/saccomax_icon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/saccomax_icon.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/fullcalender.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-3.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        .form-control,
        .form-select {
            color: midnightblue;
        }
    </style>
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Search Riho .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span
                                        class="sr-only">Loading... </span></div><i class="close-search"
                                    data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"> </div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    {{-- <div class="logo-wrapper"> <a href="index.html"><img class="img-fluid for-light"
                                src="../assets/images/logo/logo_dark.png" alt="logo-light"><img
                                class="img-fluid for-dark" src="../assets/images/logo/logo.png" alt="logo-dark"></a>
                    </div> --}}
                    <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                    <div> <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                        <div class="d-flex align-items-center gap-2 ">
                            <h4 class="f-w-600">Welcome {{ Auth::user()->first_name }}</h4><img class="mt-0"
                                src="{{ asset('assets/images/hand.gif') }}" alt="hand-gif">
                        </div>
                    </div>
                    <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Here’s What’s
                            Happening in the SACCO Today!</span></div>
                </div>
                <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                    <ul class="nav-menus">
                        <li class="profile-nav onhover-dropdown">

                            <div class="media profile-media">
                                <div class="media-body d-xxl-block d-none box-col-none">
                                    <span class="txt-primary"><i class="fa fa-users"></i> Member
                                        Portal</span>
                                </div>
                            </div>
                            @if (!empty(array_diff($roles, [2])))
                                <ul class="profile-dropdown onhover-show-div">
                                    <li><a href="{{ route('staff.home') }}" class="txt-info f-w-300"><i
                                                class="fa fa-shield"></i><span>
                                                Admin
                                                Portal</span></a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        <li>
                            <div class="mode"><i class="moon" data-feather="moon"> </i></div>
                        </li>
                        <li class="profile-nav onhover-dropdown">
                            <div class="media profile-media">

                                {{-- Profile Picture --}}
                                @if (!empty(Auth::user()->profile_picture))
                                    <img class="b-r-10" src="{{ asset(Auth::user()->profile_picture) }}"
                                        alt="" width="30px">
                                @else
                                    <img class="b-r-10" src="{{ asset('assets/images/logo/saccomax_icon.png') }}"
                                        alt="" width="30px">
                                @endif

                                <div class="media-body d-xxl-block d-none box-col-none">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span><i
                                            class="middle fa fa-angle-down"> </i>
                                    </div>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{ route('member.account_profile') }}"><i
                                            data-feather="user"></i><span>My Profile</span></a>
                                </li>
                                <li>
                                    <form action="{{ route('user-logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-pill btn-outline-primary btn-sm">Log
                                            Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                <div class="logo-wrapper"><a href="#"><img class="m-5"
                            src="{{ asset('assets/images/logo/saccomax_logo.png') }}" width="150"
                            alt=""></a>
                    <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                        </i></div>
                </div>
                <nav class="sidebar-main">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar">
                            <li class="back-btn">
                                {{-- <a href="#"><img class="img-fluid"
                                        src="{{ asset('assets/images/logo/upplogo-new.png') }}" alt=""></a> --}}
                                <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('member.home') }}">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="../assets/svg/icon-sprite.svg#fill-home"></use>
                                    </svg><span>Dashboard </span></a>
                            </li>


                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('member.savings') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                        <path
                                            d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                        <path
                                            d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                    </svg>
                                    <span>My Savings </span></a>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('member.withdrawals') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                        <path
                                            d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                        <path
                                            d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                    </svg>
                                    <span>My Withdrawals </span></a>
                            </li>


                            <li class="sidebar-list"><a class="sidebar-link sidebar-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg>
                                    <span>My Loans</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('member.loan_requests') }}">Loan Requests</a></li>
                                    <li><a href="{{ route('member.loan-payments') }}">Loan Payments</a></li>
                                    <li><a href="{{ route('member.guarantor-requests') }}">Guarantor Requests</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </div>
            <!-- Page Sidebar Ends-->
            @yield('page-body')
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright @php echo date('Y') @endphp © <a href="https://lyptusventures.com/"
                                    target="_blank">Lyptus Ventures Limited</a> </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/moment.min.js') }}"></script>
    <!-- calendar js-->
    <script src="{{ asset('assets/js/calendar/fullcalender.js') }}"></script>
    <script src="{{ asset('assets/js/calendar/custom-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/general-widget.js') }}"></script>
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $('.commaAmount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    </script>
    <script>
        // Alerts to disappear after 5 seconds
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                let alert = document.querySelector(".alert");
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-modal").forEach(item => {
                item.addEventListener("click", function() {
                    let imageUrl = this.getAttribute("data-image");
                    document.getElementById("modalImage").setAttribute("src", imageUrl);
                });
            });
        });
    </script>
    {{-- Loan Application Scripts --}}
    <script>
        $(document).ready(function() {
            // Loan Product Selection
            $('#loan_product_id').change(function() {
                const selected = $(this).find(':selected');
                if (selected.val()) {
                    $('#loan_details').show();
                    $('#max_loan_amount').text('UGX ' + parseInt(selected.data('max')).toLocaleString());
                    $('#interest_rate').text(selected.data('annual'));
                    $('#monthly_interest_rate').text(selected.data('monthly'));
                    $('#loan_period').text(selected.data('term'));
                    $('#saving_details').show();
                } else {
                    $('#loan_details').hide();
                    $('#saving_details').hide();
                }
            });

            // Guarantors Management
            $('#add_guarantor').click(function() {
                const newEntry = $('.guarantor-entry:first').clone();
                newEntry.find('input').val('');
                newEntry.find('select').val('');
                newEntry.find('.remove-guarantor').show();
                $('#guarantors_section').append(newEntry);
                initializeCommaAmount();
            });

            $(document).on('click', '.remove-guarantor', function() {
                if ($('.guarantor-entry').length > 1) {
                    $(this).closest('.guarantor-entry').remove();
                }
            });

            // Initialize comma formatting for amount inputs
            function initializeCommaAmount() {
                $('.commaAmount').off('keyup').on('keyup', function() {
                    let value = $(this).val().replace(/,/g, '');
                    value = value.replace(/\D/g, "");
                    value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $(this).val(value);
                });
            }

            initializeCommaAmount();
        });
    </script>
</body>

</html>
