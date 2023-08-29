<!doctype html>
<html lang="en">
    @include('message')
<head>
    <title>Reset Password : Lendkash</title>
    <meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- favicon -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no,user-scalable=0">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    <!-- stylesheet -->
    <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/bootstrap-select.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/jquery.mCustomScrollbar.css')}}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ url('public/css/icomoon.css')}}" type="text/css">
    <!-- <link rel="stylesheet" href="{{ url('public/css/datepicker.min.css')}}" type="text/css"> -->
    <link rel="stylesheet" href="{{ url('public/css/admin.min.css')}}" type="text/css">
    <title>Lendkash | Admin</title>

	<!-- Script Link -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

</head>
<header class="c-header">
    <div class="c-header__logo d-flex justify-content-center align-items-center">
        <a href="{{ URL::To('admin') }}">
            <img src="{{ url('public/images/logo.png')}}" class="img-fluid" alt="Lendkash">
        </a>
    </div>
    <nav class="navbar justify-content-between" id="navbar">
    </nav>
</header>
    <body class="auth">
        <main class="mainContent pl-0 pr-0 pb-0">
            <section class="auth__section d-flex align-items-center justify-content-center">
                <div class="container">
                    <div class="auth-area mx-auto ">
                        <div class="auth-area__head text-center">
                            <h1 class="font-bold">Reset Password</h1>
                        </div>
                        <div class="auth-area__form shadow">
                            <form method="POST"  id="reset_password" method="post" action="{{URL::To('admin/reset-password')}}" class="needs-validation" novalidate autocomplete="false">
                                    @csrf
                                    <input type="hidden" name="token" value="{{request()->token}}">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="" required="">
                                    <div class="invalid-feedback">
                                        Please enter new password.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="" required="">
                                    <div class="invalid-feedback">
                                        Please enter confirm password.
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary ripple-effect">RESET PASSWORD</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\ResetPasswordValidation','#reset_password') !!}
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{ url('public/js/jquery.min.js') }}"></script>
        <script src="{{ url('public/js/popper.min.js') }}"></script>
        <script src="{{ url('public/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('public/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ url('public/js/moment.js') }}"></script>
        <script src="{{ url('public/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ url('public/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/js/jsvalidation.js') }}"></script>
    </body>
</html>
