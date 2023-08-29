<!doctype html>
<html lang="en">
        @include('message')
<head>
    <title>Login : Lendkash</title>
    <meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- favicon -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no,user-scalable=0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('public/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('public/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('public/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('public/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- stylesheet -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" type="text/css"> --}}
    <link rel="stylesheet" href="{{ url('public/css/toastr.min.css')}}">

    <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/bootstrap-select.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/jquery.mCustomScrollbar.css')}}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ url('public/css/icomoon.css')}}" type="text/css">
    <!-- <link rel="stylesheet" href="{{ url('public/css/datepicker.min.css')}}" type="text/css"> -->
    <link rel="stylesheet" href="{{ url('public/css/admin.min.css')}}" type="text/css">
	<!-- Script Link -->


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
       <div class="container-fluid">
          <div class="auth-area mx-auto ">
             <div class="auth-area__head text-center">
                <h1 class="font-bold">Login</h1>
             </div>
             <div class="auth-area__form shadow">
                <form method="POST" class="needs-validation" id="loginForm" novalidate action="{{ URL::To('admin/login') }}">
                        @csrf
                    <div class="form-group">
                        <label>Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary ripple-effect"  data-url="{{ URL::To('admin/login') }}" id="login-button"> {{ __('Login') }}</button>
                    </div>
                    <div class="auth-link text-right">
                        <a class="auth-link text-right green-color" href="{{ URL::To('admin/forgot-password') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\UserValidation','#loginForm') !!}

             </div>
          </div>
       </div>
    </section>
    <!-- footer links -->
 </main>
</body>
</html>
<script src="{{ url('public/js/popper.min.js') }}"></script>
<script src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('public/js/moment.js') }}"></script>
<script src="{{ url('public/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ url('public/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/jsvalidation.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script> --}}
<script src="{{ url('/public/js/toastr.min.js') }}"></script>


<script>


    $(document).ready(function () {
        $('#login-button').click(function () {
            if ($('#loginForm').valid()) {
                showButtonLoader('login-button', 'Login', 'disable');
                url = $(this).data('url');
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: $('#loginForm').serialize(),
                    success: function (result) {
                        console.log(result);
                        if (result.success == 'false') {

                            $.each(result.message, function (key, val) {
                                $("#" + key + "-error").text(val);
                            });
                        } else {
                            // toastr.success(result.message);
                            window.location.href = SITEURL + "/admin/dashboard";
                        }

                    },
                    error: function (er) {
                        var errors = $.parseJSON(er.responseText);
                        $.each(errors.errors, function (key, val) {
                            $("#" + key + "-error").text(val);
                        });
                    },
                    complete: function () {
                        showButtonLoader('login-button', 'Login', 'enable');
                    }
                });
            }
        });
    });
</script>
