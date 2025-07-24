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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.bubble.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        .form-control,
        .form-select {
            color: midnightblue;
        }
    </style>
    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">
    <style>
        /* Ensure the dropdown is visible */
        .select2-container {
            width: 100% !important;
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
                                <div class="media-body">
                                    <span class="txt-primary"><i class="fa fa-shield"></i> Admin Portal</span>
                                </div>
                            </div>
                            @if (in_array(2, $roles))
                                <ul class="profile-dropdown onhover-show-div">
                                    <li><a href="{{ route('member.home') }}" class="txt-info"><i
                                                class="fa fa-users"></i><span style="font-size: 12px"
                                                class="f-w-500">
                                                Member Portal</span></a>
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
                                <li><a href="{{ route('staff.account_profile') }}"><i
                                            data-feather="user"></i><span>My Profile</span></a>
                                </li>
                                <br>
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
                <nav class="sidebar-main ">
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
                                    href="{{ route('staff.home') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                                    </svg><span>Dashboard </span></a>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('members.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg>
                                    <span>Members </span></a>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
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
                                    <span>Transactions</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('savings.index') }}">Savings</a></li>
                                    <li><a href="{{ route('withdrawals.index') }}">Withdrawals</a></li>
                                </ul>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
                                    </svg>
                                    <span>Loans</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('staff.loan-requests') }}">Loan Requests</a></li>
                                    <li><a href="{{ route('staff.loan-payments.index') }}">Loan Payments</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-clipboard2-data" viewBox="0 0 16 16">
                                        <path
                                            d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                                        <path
                                            d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                                        <path
                                            d="M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1" />
                                    </svg>
                                    <span>Reports</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('staff.members.report', 'all') }}">Members</a></li>
                                </ul>
                            </li>

                            {{-- Available to only Admin --}}
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>System Settings</h6>
                                </div>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('messages.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                        <path
                                            d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                    </svg>
                                    <span>Messages </span></a>
                            </li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                                        <path
                                            d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                                    </svg>
                                    <span>Configurations</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('loan-product.index') }}">Loan Products</a></li>
                                    <li><a href="#">Role Management</a></li>
                                    <li><a href="{{ route('audit-logs.index') }}">Audit Logs</a></li>
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
    <script>
        $(document).ready(function() {
            console.log("Initializing Select2...");
            console.log($.fn.select2); // Debugging: Check if Select2 is loaded

            if ($.fn.select2) {
                $('#example-select').select2({
                    placeholder: "Choose options...",
                    allowClear: true
                });
                console.log("Select2 initialized successfully!");
            } else {
                console.error("Select2 is not loaded!");
            }
        });
    </script>
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
    <script src="{{ asset('assets/js/general-widget.js') }}"></script>
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/editors/quill.js') }}"></script>
    <script src="{{ asset('assets/js/custom-add-product3.js') }}"></script>
    <script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
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
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-modal").forEach(item => {
                item.addEventListener("click", function() {
                    let imageUrl = this.getAttribute("data-image");
                    document.getElementById("modalImage").setAttribute("src", imageUrl);
                    document.getElementById("modalImage2").setAttribute("src", imageUrl);
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
