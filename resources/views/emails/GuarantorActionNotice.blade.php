<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="SaccoMax – Smart, secure SACCO management software to digitize operations, manage savings & loans, and empower your cooperative’s future.">
    <meta name="keywords"
        content="SACCO software, cooperative management system, SaccoMax, digital SACCO platform, savings and credit software, cooperative solutions, SACCO ERP, loan management system">

    <link rel="icon" href="{{ asset('assets/images/logo/saccomax_icon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/saccomax_icon.png') }}" type="image/x-icon">
    <title>SaccoMax</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f6f7fb;
            display: block;
            width: 650px;
            padding: 0 12px;
        }

        a {
            text-decoration: none;
        }

        span {
            font-size: 14px;
        }

        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }

        .text-center {
            text-align: center
        }

        @media only screen and (max-width: 767px) {
            body {
                width: auto;
                margin: 20px auto;
            }

            .logo-sec {
                width: 500px !important;
            }
        }

        @media only screen and (max-width: 575px) {
            .logo-sec {
                width: 400px !important;
            }
        }

        @media only screen and (max-width: 480px) {
            .logo-sec {
                width: 300px !important;
            }
        }

        @media only screen and (max-width: 360px) {
            .logo-sec {
                width: 250px !important;
            }
        }
    </style>
</head>

<body style="margin: 30px auto;">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <table style="background-color: #f6f7fb; width: 100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table style="margin: 0 auto; margin-bottom: 30px">
                                        <tbody>
                                            <tr class="logo-sec"
                                                style="display: flex; align-items: center; justify-content: space-between; width: 650px;">
                                                <td><img class="img-fluid"
                                                        src="{{ asset('assets/images/logo/saccomax_logo.png') }}"
                                                        alt="" width="100"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style=" margin: 0 auto; background-color: #fff; border-radius: 8px">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 30px">
                                                    <p>Dear <strong>{{ $details['member_name'] }}</strong>,</p>
                                                    <p>
                                                        <strong>{{ $details['guarantor_name'] }}</strong> has
                                                        <strong>{{ $details['status'] }}</strong> to guarantee your loan
                                                        application.
                                                    </p>

                                                    <div class="details">
                                                        <p><strong>Loan Details:</strong></p>
                                                        <p>Loan Product:
                                                            <strong>{{ $details['loan_product'] }}</strong>
                                                        </p>
                                                        <p>Loan Amount:
                                                            <strong>{{ 'UGX ' . number_format($details['loan_amount']) }}</strong>
                                                        </p>
                                                        <p>Guarantor Amount:
                                                            <strong>{{ 'UGX ' . number_format($details['guarantor_amount']) }}</strong>
                                                        </p>

                                                    </div>
                                                    <br>
                                                    <p>Thank you for choosing SaccoMax — empowering your SACCO’s future./p>
                                                    <p style="margin-top:2em">Regards,</p>
                                                    <p><i><strong>SaccoMax Management</strong></i></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
