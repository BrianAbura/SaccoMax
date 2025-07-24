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
    <style>
        .welcome-curtain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e2f3f 0%, #2c3e50 100%);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease-in-out;
        }

        .welcome-curtain::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 20%, rgba(50, 205, 50, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(50, 205, 50, 0.15) 0%, transparent 40%);
            pointer-events: none;
        }

        .welcome-curtain.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .welcome-content {
            text-align: center;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            width: 500px;
        }

        .welcome-logo {
            width: 300px;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .welcome-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.4s;
            animation-fill-mode: both;
            color: #2c3e50;
            font-weight: 500;
            line-height: 1.4;
        }

        .welcome-content button {
            animation: fadeInUp 0.8s ease-out 0.6s;
            animation-fill-mode: both;
            background: #32CD32;
            border: none;
            padding: 0.7rem 1.8rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
        }

        .welcome-content button:hover {
            background: #2db82d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 205, 50, 0.3);
        }
    </style>
</head>

<body>
    <!-- login page start-->
    <!-- Welcome Curtain -->
    <div class="welcome-curtain" id="welcomeCurtain">
        <div class="welcome-content">
            <img src="{{ asset('assets/images/logo/saccomax_logo.png') }}" alt="SACCOMAX Logo" class="welcome-logo"
                width="500">
            <p>Smart, Secure, Scalable SACCO Management</p>
            <button class="btn btn-primary" onclick="hideCurtain()">Click to Continue</button>
        </div>
    </div>

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
                            <form class="theme-form" method="POST" action="{{ route('user-login') }}">
                                @csrf
                                <h4>Login to account </h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" required="" autocomplete="off"
                                        name="email_address" placeholder="Enter your email address">
                                    @error('email_address')
                                        <div class="form-text text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="login_password"
                                            required="" placeholder="Enter Password" autocomplete="off">
                                        @error('login_password')
                                            <div class="form-text text-warning">{{ $message }}</div>
                                        @enderror
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                </div>

                                <div class="mb-4 mt-4">
                                    <a href="{{ route('password.request') }}">Forgot Password? Click Here</a>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Curtain Animation Script -->
        <script>
            function hideCurtain() {
                const curtain = document.getElementById('welcomeCurtain');
                curtain.classList.add('fade-out');
                // Remove the curtain from DOM after animation completes
                setTimeout(() => {
                    curtain.remove();
                }, 500);
            }
        </script>

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
