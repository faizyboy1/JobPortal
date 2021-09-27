<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>{{ __($pageTitle) }}</title>

    <style>
        :root {
            --main-color: {{ $frontTheme->primary_color }};
        }

        {!! $frontTheme->front_custom_css !!}
    </style>

    <!-- Styles -->
    <link href="{{ asset('froiden-helper/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">

    <link href="{{ asset('front/assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/thesaas.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/custom.css') }}" rel="stylesheet">

    <!-- Favicons -->
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
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    @stack('head-style')
</head>

<body>


<!-- Topbar -->
<nav class="topbar topbar-inverse topbar-expand-md">
    <div class="container">

        <div class="topbar-left">
            {{-- <button class="topbar-toggler">&#9776;</button> --}}
            <a class="topbar-brand" href="{{ url('/') }}">
                <img src="{{ $global->logo_url }}" class="logo-inverse" alt="home" />
            </a>
        </div>


        {{--<div class="topbar-right">--}}
            {{--<div class="d-inline-flex ml-30">--}}
                {{--<a class="btn btn-sm btn-primary mr-4" href="page-login.html">@lang('modules.front.visitMainWebsite') <i class="fa fa-arrow-right"></i></a>--}}
            {{--</div>--}}
        {{--</div>--}}

    </div>
</nav>
<!-- END Topbar -->



<!-- Header -->
<header class="header header-inverse" style="background-image: url({{ $frontTheme->background_image_url }});padding: 80px 100px;" data-overlay="8">
</header>
<!-- END Header -->




<!-- Main container -->
<main class="main-content">

    @yield('content')

</main>
<!-- END Main container -->






<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-12 col-lg-3">
                &copy; {{ \Carbon\Carbon::today()->year }} @lang('app.by') {{ $companyName }}

            </div>
        </div>
    </div>
</footer>
<!-- END Footer -->



<!-- Scripts -->
<script src="{{ asset('front/assets/js/core.min.js') }}"></script>
<script src="{{ asset('front/assets/js/thesaas.min.js') }}"></script>
<script src="{{ asset('front/assets/js/script.js') }}"></script>
<script src="{{ asset('froiden-helper/helper.js') }}"></script>
<script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>

@stack('footer-script')

</body>
</html>