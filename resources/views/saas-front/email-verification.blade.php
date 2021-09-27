<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $setting->company_name }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="{{ $headerData->meta_details['title'] ?: '' }}">
        <meta name="description" content="{{ $headerData->meta_details['description'] ?: '' }}">
        <meta name="keywords" content="{{ $headerData->meta_details['keywords'] ?: '' }}">
        <link href="{{ asset('saas-front/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/socicon.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/flickity.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/iconsmind.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/jquery.steps.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('froiden-helper/helper.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
        <link href="{{ asset('saas-front/css/theme.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('saas-front/css/custom.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body class=" ">
        <a id="start"></a>
        <div class="nav-container d-block d-sm-none">
            <nav class="bar bar-4 bar--transparent bar--absolute" data-fixed-at="200">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-md-offset-0 col-4">
                            <div class="bar__module">
                                <a href="index.html">
                                    <img class="logo logo-dark" alt="logo" src="{{ $headerData->logo_url }}" />
                                </a>
                            </div>
                            <!--end module-->
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </nav>
            <!--end bar-->
        </div>
        <div class="main-container">
            <section class="imageblock switchable feature-large height-100">
                <div class="imageblock__content col-lg-5 col-md-4 pos-right">
                    <div class="background-image-holder">
                        <img alt="image" src="{{ $headerData->register_background_image_url }}" />
                    </div>
                </div>
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <div class="alert bg--{{$class}}">
                                <div class="alert__body">
                                    <span>{!! $messsage !!} <a href="{{ route('login') }}">@lang('email.loginDashboard')</a></span>
                                </div>
                                <div class="alert__close">×</div>
                            </div>
                            
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
        </div>
        <!--<div class="loader"></div>-->
        <a class="back-to-top inner-link" href="#start" data-scroll-class="100vh:active">
            <i class="stack-interface stack-up-open-big"></i>
        </a>
        <script src="{{ asset('saas-front/js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('saas-front/js/smooth-scroll.min.js') }}"></script>
        <script src="{{ asset('saas-front/js/scripts.js') }}"></script>


    </body>
</html>