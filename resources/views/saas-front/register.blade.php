<!doctype html>
<html lang="en">
    <head>
    <style>
            .required:after { content:" *";color: crimson;}

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
        <script>
            function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            }
           
        </script>
<style>     
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

select.form-control-lg:not([size]):not([multiple]) {
    -webkit-appearance: none;
    background: #fcfcfc;
    border-radius: 6px;
    border: 1px solid #ececec;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
  width: 50%;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  /* border: 1px solid #ccc; */
  border-top: none;
}
</style>

    </head>
    <body class=" ">
        <!-- Tab links -->

        <a id="start"></a>
        <div class="nav-container d-block d-sm-none">
            <nav class="bar bar-4 baaar--transparent bar--absolute" data-fixed-at="200">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-md-offset-0 col-4">
                            <div class="bar__module">
                                <a href="{{ url('/')}}">
                                    <img class="logo logo-dark" alt="logo" src="{{ $firstHeaderData->logo_url }}" height="50px" />
                                </a>
                            </div>
                            <!--end module-->
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

                                <!-- <div class="row mt-4">
                                    <div class="col-md-6 tabs">
                                        <h2 class="text-center">Employeer</h2>
                                    </div>
                                    <div class="col-md-6 tabs">
                                        <h2 class="text-center">Candidate</h2>
                                    </div>
                                </div> -->
                               

                            <a href="{{ url('/')}}" class="d-none d-sm-block">
                                <img class="logo logo-light float-right" alt="logo" src="{{ $headerData->logo_url }}"  height="40px"/>
                            </a>
                            <h2>@lang('modules.register.signUp')</h2>
                                <div class="tab">
                                    <button class="tablinks" onclick="openCity(event, 'Employer')">Employer</button>
                                    <button class="tablinks active" onclick="openCity(event, 'Candidate')">Candidate</button>
                                </div>
                               
                                    <!-- Tab content -->
                                <div id="Employer" class="tabcontent">
                                    <form class="ajax-form" method="POST" id="createForm" onsubmit="return false;">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5 class="text-uppercase required">@lang('modules.register.companyDetails')</h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" id="company_name" name="company_name" class="form-control" placeholder="@lang('modules.accountSettings.companyName')" />
                                                    </div>
                                            </div>
                                           
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" name="career_page_link" id="career_page_link" class="form-control" placeholder="@lang('modules.register.careerPageLink')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                <select class="form-control form-control-lg" name="ctg_id">
                                                    <option>@lang('modules.register.selectIndustry')</option>
                                                        @foreach($categories as $data)
                                                            <option value="{{$data['id']}}">{{$data['company_name']}}</option>
                                                        @endforeach
                                                </select>
                                        </div> 

                                        @if(module_enabled('Subdomain'))
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" placeholder="subdomain"
                                                                name="sub_domain" id="sub_domain">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                id="basic-addon2">.{{ get_domain() }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <!--end row-->
                                        <div class="row">
                                            <div class="col-sm-12 mt-2">
                                                <h5 class="text-uppercase required">@lang('modules.register.accountDetails')</h5>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="account_details" name="account_details" placeholder="@lang('modules.front.AccountDetails')" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <input type="email" name="email" placeholder="@lang('modules.front.email')" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <input type="password" name="password" placeholder="@lang('app.password')" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                @if($setting->google_recaptcha_key)
                                                    <div class="g-recaptcha" data-sitekey="{{ $setting->google_recaptcha_key }}"></div>
                                                @endif
                                            <br>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" id="save-form" class="btn btn--primary type--uppercase">@lang('modules.register.createAccount')</button>
                                            </div>
                                            <div class="col-12">
                                                <div>
                                                    <span class="type--fine-print">@lang('modules.register.alreadyRegistered')
                                                        <a href="{{ route('login') }}">@lang('modules.register.login')</a>
                                                    </span>

                                                </div>

                                            </div>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>

                                <div id="Candidate" class="tabcontent" style="display : block;">
                                    <form id="createCandidateForm" method="POST">
                                                @csrf
                                                <input type="hidden" name="job_id" value="">

                                                <div class="container">
                                                    <div class="row gap-y">
                                                    
                                                        <div class="col-md-12 pb-30 mt-50">
                                                        <h5 class="px-20 pb-30 mt-50">@lang('modules.front.personalInformation')</h5>
                                                            <div class="row"> 
                                                                <div class="col mb-3">
                                                                    <input class="form-control form-control-lg" type="text" name="first_name" placeholder="@lang('modules.register.firstName')" value="@if($user) {{ $user->name }} @endif">
                                                                </div>

                                                                <div class="col">
                                                                    <input class="form-control form-control-lg" type="text" name="middle_name" placeholder="@lang('modules.register.middleName')" value="@if($user) {{ $user->name }} @endif">
                                                                </div>

                                                                <div class="col">
                                                                    <input class="form-control form-control-lg" type="text" name="last_name" placeholder="@lang('modules.register.lastName')" value="@if($user) {{ $user->name }} @endif">
                                                                </div>
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
                                                                <select class="form-control form-control-lg" name="ctg_id">
                                                                        <option>@lang('modules.register.selectIndustry')</option>
                                                                    @foreach($categories as $data)
                                                                         <option value="{{$data['id']}}">{{$data['company_name']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div> 

                                                            <!-- <div class="form-group">
                                                                <h6 class="mb-0">@lang('modules.front.photo')</h6>
                                                                <input class="select-file" accept=".png,.jpg,.jpeg" type="file" name="photo">
                                                            </div>
                                                            

                                                            <div class="form-group">
                                                                <h6 class="mb-0">@lang('modules.front.resume')</h6>
                                                                <input class="select-file" accept=".pdf" type="file" name="resume">
                                                            </div> -->

                                                            <div class="row">
                                                                <div class="col">
                                                                    <input class="form-control form-control-lg" type="password" name="password"
                                                                        placeholder="Password" value="@if($user) {{ $user->password }} @endif">
                                                                </div>
                                                        
                                                                <div class="col">
                                                                    <input class="form-control form-control-lg" type="password" name="confirm-password"
                                                                        placeholder="Confirm Password" value="@if($user) {{ $user->password }} @endif">
                                                                </div>
                                                            </div>

                                                            <!-- <div class="form-group">
                                                                <div class="col-md-6 mb-4">
                                                                    <input class="form-control form-control-lg" type="text" name="education"
                                                                        placeholder="Education Level" value="">
                                                                </div>
                                                        
                                                                <div class="col-md-6 mb-4">
                                                                    <input class="form-control form-control-lg" type="text" name="country"
                                                                        placeholder="Current Work Country" value="">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-6 mb-4">
                                                                    <input class="form-control form-control-lg" type="text" name="experience"
                                                                        placeholder="Year of experience" value="">
                                                                </div>
                                                        
                                                                <div class="col-md-6 mb-4">
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
                                                            </div> -->
                                                            
                                                            <div class="col-md-12 pb-30">
                                                                <div class="row">
                                                                    <div class="col-md-12 mt-5 mb-4">
                                                                        <button class="btn btn-lg btn-primary btn-block theme-background" id="save-candidate-form" type="button">@lang('modules.register.createAccount')</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div>
                                                                    <span class="type--fine-print">@lang('modules.register.alreadyRegistered')
                                                                        <a href="{{ route('login') }}">@lang('modules.register.login')</a>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                    </form>
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
                @if(!is_null($setting->google_recaptcha_key))
                    if(grecaptcha.getResponse().length == 0){
                        e.preventDefault();
                        alert('Please click the reCAPTCHA checkbox');
                        return false;
                    }
                @endif
                $.easyAjax({
                    url: "{{route('company-register')}}",
                    container: '#createForm',
                    type: "POST",
                    data: $('#createForm').serialize(),
                    success: function(response) {
                        $('#createForm').trigger("reset");
                        swal("Sent!", "Your account has been created successfully.\n Check your email to activate your account.", "success");
                    }
                    // ,
                    // error: function (response) {
                    //     swal("Error!", "Your need to fill all the form fields!", "error");
                    // }
                })
            });

            $('#save-candidate-form').click(function (e) {
                $.easyAjax({
                url: "{{route('candidate-register')}}",
                container: '#createCandidateForm',
                type: "POST",
                file:true,
                redirect: true,
<<<<<<< HEAD
                // data: $('#createCandidateForm').serialize(),
=======
                 data: $('#createForm').serialize(),
>>>>>>> c313df182768d6e864f281d83429c715519ad767
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
