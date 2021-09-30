<!doctype html>
<html lang="en">
    <head>
    <style>
            .required:after { 
                content:" *";color: crimson;
            }
            label {
                font-size: 14px !important;
            }
            input[type="radio"], input[type="checkbox"] {
                width: 100% !important;
            }
            .form-group {
                margin: 30px !important;
                padding: 0;
            }

        </style>
        <meta charset="utf-8">
        <title>{{ $setting->company_name }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="{{ $headerData->meta_details['title'] ?: '' }}">
        <meta name="description" content="{{ $headerData->meta_details['description'] ?: '' }}">
        <meta name="keywords" content="{{ $headerData->meta_details['keywords'] ?: '' }}">

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
        <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">

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
        <script src="https://www.google.com/recaptcha/api.js"></script>

    </head>
    <body class=" ">
        <a id="start"></a>
        <div class="nav-container d-block d-sm-none">
            <nav class="bar bar-4 bar--transparent bar--absolute" data-fixed-at="200">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-md-offset-0 col-4">
                            <div class="bar__module">
                                <a href="{{ url('/')}}">
                                    <img class="logo logo-dark" alt="logo" src="{{ $firstHeaderData->logo_url }}" height="50px" />
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
                    <div class="container-fluid">
                       
                            <div class="col-lg-7 col-md-7">
                                <a href="{{ url('/')}}" class="d-none d-sm-block">
                                    <img class="logo logo-light float-right" alt="logo" src="{{ $headerData->logo_url }}"  height="40px"/>
                                </a>
                                <h2>@lang('modules.register.signUp')</h2>
                                <p class="lead">@lang('modules.register.subHeading')</p>
                                
                                <form id="createForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="job_id" value="">

                                    <div class="container">
                                        <div class="row gap-y">
                                        
                                        

                                            <div class="col-md-8 pb-30 mt-50">

                                                <div class="form-group">
                                                    <input class="form-control form-control-lg" type="text" name="full_name" placeholder="@lang('modules.front.fullName')" value="@if($user) {{ $user->name }} @endif">
                                                </div>

                                                <div class="form-group">
                                                    <input class="form-control form-control-lg" type="email" name="email"
                                                            placeholder="@lang('modules.front.email')" value="@if($user) {{ $user->email }} @endif">
                                                </div>

                                                <div class="form-group">
                                                    <input class="form-control form-control-lg" type="tel" name="phone"
                                                            placeholder="@lang('modules.front.phone')">
                                                </div>

                                                <div class="form-group">
                                                    <h6 class="mb-0">@lang('modules.front.photo')</h6>
                                                    <input class="select-file" accept=".png,.jpg,.jpeg" type="file" name="photo">
                                                </div>
                                                

                                                <div class="form-group">
                                                    <h6 class="mb-0">@lang('modules.front.resume')</h6>
                                                    <input class="select-file" accept=".pdf" type="file" name="resume">
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="password" name="password"
                                                            placeholder="Password" value="@if($user) {{ $user->password }} @endif">
                                                    </div>
                                            
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="password" name="confirm-password"
                                                            placeholder="Confirm Password" value="@if($user) {{ $user->password }} @endif">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="text" name="education"
                                                            placeholder="Education Level" value="">
                                                    </div>
                                            
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="text" name="country"
                                                            placeholder="Current Work Country" value="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="text" name="experience"
                                                            placeholder="Year of experience" value="">
                                                    </div>
                                            
                                                    <div class="col-md-6">
                                                        <input class="form-control form-control-lg" type="text" name="citizenship"
                                                            placeholder="Citizenship" value="">
                                                    </div>
                                                </div>
 
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 mt-3">Can you be located in another country?</h6>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input class="custom-control-input col-md-12" type="radio" name="relocatable" id="inlineRadio1" value="1">
                                                            <label class="custom-control-label" for="inlineRadio1">Yes</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input class="custom-control-input col-md-12" type="radio" name="relocatable" id="inlineRadio2" value="0">
                                                            <label class="custom-control-label" for="inlineRadio2">No</label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <h6 class="mb-0 mt-3">Transferable work permit</h6>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input class="custom-control-input col-md-12" type="radio" name="transferable" id="inlineRadio3" value="1">
                                                            <label class="custom-control-label" for="inlineRadio3">Yes</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input class="custom-control-input col-md-12" type="radio" name="transferable" id="inlineRadio4" value="0">
                                                            <label class="custom-control-label" for="inlineRadio4">No</label>
                                                        </div>
                                                        
                                                    </div>    
                                                </div>
                                                
                                                <div class="col-md-12 pb-30">
                                                    <div class="row">
                                                        <div class="col-md-12 mt-5">
                                                            <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">@lang('modules.front.submitApplication')</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4 px-20 pb-30 mt-50">
                                                <h5>@lang('modules.front.personalInformation')</h5>
                                            </div>
                                    
                                    
                                        </div>
                                    </div>
                                </form>
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
        <script src="{{ asset('froiden-helper/helper.js') }}"></script>
        <script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
        <script src="{{ asset('assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>

        <script>

            $('#company_name').blur(function(){
                var text = $('#company_name').val();
                var slug = convertToSlug(text);
                $('#career_page_link').val(slug);
            })

            $('#company_name').keyup(function(){
                var text = $('#company_name').val();
                var slug = convertToSlug(text);
                $('#career_page_link').val(slug);
            })

            $('#career_page_link').blur(function(){
                var slug = convertToSlug2($(this).val());
                $('#career_page_link').val(slug);
            })

            function convertToSlug(Text)
            {
                return Text
                    .toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-')
                    ;
            }

            function convertToSlug2(Text)
            {
                return Text
                    .toLowerCase()
                    // .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-')
                    ;
            }

            $('#save-form').click(function (e) {
                $.easyAjax({
                url: "{{route('candidate-register')}}",
                container: '#createForm',
                type: "POST",
                file:true,
                redirect: true,
                // data: $('#createForm').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        var successMsg = '<div class="alert alert-success my-100" role="alert">' +
                            response.msg + ' <a class="" href="{{ jobOpenings($global->career_page_link) }}">{{ __("app.view").' '.__("modules.front.jobOpenings") }} <i class="fa fa-arrow-right"></i></a>'
                            '</div>';
                        $('.main-content .container').html(successMsg);
                        $('.main-content').css('bg', '#ffffff');
                    }
                },
                error: function (response) {
                    handleFails(response);
                }
            })
            });
        </script>

    </body>
</html>
