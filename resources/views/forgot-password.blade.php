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
    <title>SaccoMax</title>
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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 p-0">
                <div class="login-card login-dark">
                    <div class="col-xl-6"></div>
                    <div class="col-xl-5">

                        {{-- Alerts for the home page --}}
                        @if (session('success'))
                            <div class="alert alert-light-success alert-dismissible fade show col-md-8 mx-auto"
                                role="alert">
                                <p class="txt-info"> {{ session('success') }}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-light-secondary alert-dismissible fade show col-md-8 mx-auto"
                                role="alert">
                                <p class="txt-info"> {{ session('error') }}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- Alerts for the home page --}}

                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <h4>Forgot your Password </h4>
                                <p>Enter your email and we'll send you password reset instructions</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" required="" autocomplete="off"
                                        name="email" placeholder="Enter your email address">
                                    @error('email')
                                        <div class="form-text text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <button class="btn btn-info btn-block w-100" type="submit">Send Reset
                                        Link</button>
                                </div>

                                <div class="mb-4 mt-4">
                                    <a href="{{ route('login') }}">Return to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        <!-- Sidebar jquery-->
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <!-- Plugins JS start-->
        <!-- calendar js-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('assets/js/script.js') }}"></script>
    </div>
</body>

</html>
