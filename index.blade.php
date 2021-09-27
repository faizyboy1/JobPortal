@extends('layouts.saas-front')

@push('meta_details')
    <title>{{ $headerData->meta_details['title'] ?: 'Recruit' }}</title>

    <meta name="title" content="{{ $headerData->meta_details['title'] ?: '' }}">
    <meta name="description" content="{{ $headerData->meta_details['description'] ?: '' }}">
    <meta name="keywords" content="{{ $headerData->meta_details['keywords'] ?: '' }}">
@endpush

@push('header_css')
    @if($firstHeaderData->header_background_color != '')
        <style>
            .background-color {
                border: none;
                background: {{ $firstHeaderData->header_background_color }}
            }

            #header-section {
                background: {{ $firstHeaderData->header_background_color }}
            }

            .feature-icon {
                color: {{ $firstHeaderData->header_background_color }}
            }

        </style>
    @endif

    @if($headerData->header_background_image != '')
        <style>
            #header-section {
                background: url("{{ $headerData->header_backround_image_url }}");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            #header-section:before {
                content: "";
                position: absolute;
                left: 0; right: 0;
                top: 0; bottom: 0;
                background: rgba(0,0,0,.3);
            }
        </style>
    @endif

    @if($firstHeaderData->custom_css != '')
        <style>
            {!! $firstHeaderData->custom_css !!}
        </style>
    @endif
@endpush

@section('content')
    <section class="switchable switchable--switch bg--primary" id="header-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-7">
                    <div class="mt--2">
                        <h1> {{ $headerData->title }} </h1>
                        <p class="lead"> {!! $headerData->description !!} </p>

                        @if($firstHeaderData->show_register_in_header)
                        <a class="btn btn--primary type--uppercase" href="{{ route('register') }}">
                            <span class="btn__text">
                                @lang('app.register')
                            </span>
                        </a>
                        @endif

                        @if($firstHeaderData->show_login_in_header)
                        <a class="btn btn--primary type--uppercase" href="{{ route('login') }}">
                            <span class="btn__text">
                                @lang('app.login')
                            </span>
                        </a>
                        @endif

                <span class="block type--fine-print"><br></span> </div>
                </div>
                <div class="col-lg-7 col-md-5 col-12"> <img alt="Image" src="{{ $headerData->header_image_url }}"> </div>
            </div>
        </div>
    </section>

    <section class=" ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="slider slider--inline-arrows slider--arrows-hover text-center" data-arrows="true">
                        <ul class="slides">
                            @forelse($featuredCompanies as $featuredCompany)
                            <li class="col-md-3 col-6">
                                <a href="{{ route('jobs.jobOpenings') }}" target="_blank">
                                    <img alt="Image" class="image--xs" src="{{ $featuredCompany->logo_url }}" />
                                </a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!--end of col-->
            </div>
            <!--end row-->
        </div>
        <!--end of container-->
    </section>

    <div id="features">
        @foreach ($imageFeatures as $key=>$item)
            <section @if($key%2 == 0) class="switchable feature-large" @else class="switchable feature-large  switchable--switch bg--secondary" @endif>
                <div class="container">
                    <div class="row justify-content-around">
                        <div class="col-md-6"> <img alt="{{ $item->title }}" class="border--round box-shadow-wide" src="{{ $item->image_url }}"> </div>
                        <div class="col-md-6 col-lg-5">
                            <div class="switchable__text">
                                <h2>{{ ucfirst($item->title) }}</h2>
                                <p class="lead">{{ ucfirst($item->description) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        @if(count($iconFeatures) > 0)
            <section class="text-center">
                <div class="container">
                    <div class="row">
                        @foreach ($iconFeatures as $item)
                            <div class="col-md-6 col-lg-3">
                                <div class="text-block boxed boxed--sm boxed--border"> <i class="feature-icon icon--sm {{ $item->icon }} color--dark"></i>
                                    <h5>{{ ucfirst($item->title) }}</h5>
                                    <p>{{ ucfirst($item->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    @if(count($feedbacks) > 0)
    <section class="text-center bg--dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                    <div class="slider" data-paging="true">
                        <ul class="slides">
                            @foreach ($feedbacks as $item)
                                <li>
                                    <div class="testimonial">
                                    <blockquote> “{{ ucfirst($item->feedback) }}” </blockquote>
                                        <h5>{{ ucfirst($item->client_title) }}</h5></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="pricing-section-2 text-center" id="pricing">
        <div class="container">
            <div class="row">

                <div class="col-md-12 mb-3">
                    @lang('app.monthlyPackages')  <input id="package-switch" @if($global->package_type == 'annual') checked @endif type="checkbox" class="js-switch" />  @lang('app.yearlyPackages')
                </div>
                @foreach ($packages as $item)
                <div class="col-md-6 col-lg-4 monthly-packages">
                    <div class="pricing pricing-3">
                        @if($item->recommended)
                            <div class="pricing__head bg--primary boxed background-color"> <span class="label">@lang('modules.saasFront.recommended')</span>
                                <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->monthly_price }}</span>
                                <p class="type--fine-print">Per Month, {{ $global->currency->currency_code }}.</p>
                            </div>
                        @else
                            <div class="pricing__head bg--secondary boxed">
                            <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->monthly_price }}</span>
                                <p class="type--fine-print">Per Month, {{ $global->currency->currency_code }}.</p>
                            </div>
                        @endif
                        <ul>
                            @if ($item->career_website)
                                <li>
                                    <span>@lang('modules.saasFront.careerWebsite')</span>
                                </li>
                            @endif
                            @if ($item->multiple_roles)
                                <li>
                                    <span>@lang('modules.saasFront.multipleRoles')</span>
                                </li>
                            @endif
                            <li>
                                <span>{!! ($item->no_of_job_openings > 0) ? $item->no_of_job_openings : "Unlimited" !!} @lang('modules.saasFront.activeJobs')</span>
                            </li>
                            <li>
                                <span>{!! ($item->no_of_candidate_access > 0) ? $item->no_of_candidate_access : "Unlimited" !!} @lang('modules.saasFront.candidateAccess')</span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach

                @foreach ($packages as $item)
                <div class="col-md-6 col-lg-4 annual-packages" style="display:none;">
                    <div class="pricing pricing-3">
                        @if($item->recommended)
                            <div class="pricing__head bg--primary boxed background-color"> <span class="label">@lang('modules.saasFront.recommended')</span>
                                <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->annual_price }}</span>
                                <p class="type--fine-print">Per Year, {{ $global->currency->currency_code }}.</p>
                            </div>
                        @else
                            <div class="pricing__head bg--secondary boxed">
                            <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->annual_price }}</span>
                                <p class="type--fine-print">Per Year, {{ $global->currency->currency_code }}.</p>
                            </div>
                        @endif
                        <ul>
                            @if ($item->career_website)
                                <li>
                                    <span>@lang('modules.saasFront.careerWebsite')</span>
                                </li>
                            @endif
                            @if ($item->multiple_roles)
                                <li>
                                    <span>@lang('modules.saasFront.multipleRoles')</span>
                                </li>
                            @endif
                            <li>
                                <span>{!! ($item->no_of_job_openings > 0) ? $item->no_of_job_openings : "Unlimited" !!} @lang('modules.saasFront.activeJobs')</span>
                            </li>
                            <li>
                                <span>{!! ($item->no_of_candidate_access > 0) ? $item->no_of_candidate_access : "Unlimited" !!} @lang('modules.saasFront.candidateAccess')</span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </section>
    <section class="text-center imagebg" data-gradient-bg="#4876BD,#5448BD,#8F48BD,#BD48B1">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6">
                    <div class="cta">
                        <h2>{{ $headerData->call_to_action_title }}</h2>

                        @if($headerData->call_to_action_button == 'login')
                        <a class="btn btn--primary type--uppercase background-color" href="{{ route('login') }}">
                            <span class="btn__text">
                                @lang('app.login')
                            </span>
                        </a>
                        @endif

                        @if($headerData->call_to_action_button == 'register')
                        <a class="btn btn--primary type--uppercase background-color" href="{{ route('register') }}">
                            <span class="btn__text">
                                @lang('app.register')
                            </span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="switchable" id="contact">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-5">
                <p class="lead">{!! $headerData->contact_text !!}</p>
                </div>
                <div class="col-md-6 col-12">
                    <form class="ajax-form row mx-0" id="createForm">
                        @csrf
                        <div class="col-md-6 col-12">
                            <label>@lang('modules.front.yourName'):</label>
                            <input type="text" name="name" class="validate-required">
                        </div>
                        <div class="col-md-6 col-12">
                            <label>@lang('modules.front.emailAddress'):</label>
                            <input type="email" name="email" class="validate-required validate-email">
                        </div>
                        <div class="col-md-12 col-12">
                            <label>@lang('modules.front.message'):</label>
                            <textarea rows="4" name="message" class="validate-required"></textarea>
                        </div>

                        <div class="col-md-12 col-12">
                        <div class="g-recaptcha" data-sitekey="{{ $global->google_recaptcha_key }}"></div>
                        <br>
                        </div>

                        <div class="col-md-5 col-lg-4 col-6">
                            <a href="javascript:;" id="save-form" class="btn btn--primary type--uppercase background-color">
                                <span class="btn__text">@lang('modules.front.sendEnquiry')</span>
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection