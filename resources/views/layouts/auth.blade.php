<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="@if(isset($headerData->meta_details['title'])) {{ $headerData->meta_details['title']}} @endif">
    <meta name="description" content="@if(isset($headerData->meta_details['description'])) {{ $headerData->meta_details['description']}} @endif">
    <meta name="keywords" content="@if(isset($headerData->meta_details['keywords'])) {{ $headerData->meta_details['keywords']}} @endif">

    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>{{ $setting->company_name }}</title>

    <style>
        :root {
            --main-color: {{ $frontTheme->primary_color }};
        }

    </style>
    <!-- page css -->
    <link href="{{ asset('assets/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="https://www.google.com/recaptcha/api.js"></script>
<style>
    .imageblock > .container, .imageblock > div[class*='col-']:not(.imageblock__content) {
        padding-bottom: 0 !important;
    }
</style>
</head>

<body class="hold-transition login-page"
      style="background-image:url({{ module_enabled('Subdomain')?$setting->login_background_image_url:$headerData->login_background_image_url }})">
<div class="login-box" >
    <div class="login-logo">
        <a href="{{ url('/')}}" >
            <img src="{{ $setting->logo_url }}" style="max-height: 40px" alt="">
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">

            @yield('content')
            @if(!module_enabled('Subdomain'))
            <div class="form-actions  pt-3">
                <a href="{{route('index')}}" class="btn btn-sm btn-block btn-rounded btn-outline-success text-uppercase">{{__('messages.frontwebsite')}}</a>
            </div>
             @endif
        </div>
        <!-- /.login-card-body -->
    </div>
</div>


<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<!--Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        // $(".preloader").fadeOut();
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    $('#save-form').click(function (e) {
        @if(!is_null($global->google_recaptcha_key))
            if(grecaptcha.getResponse().length == 0){
                e.preventDefault();
                alert('Please click the reCAPTCHA checkbox');
            }
        @endif
    });
</script>

</body>

</html>
