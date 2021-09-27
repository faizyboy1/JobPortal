<style>
    .footer {
        position: relative;
    }

    .footer.bg-dark .widget-title,
    .footer.bg-dark .footer__widgets a:hover {
        color: #fff;
    }

    .footer.bg-dark .footer__widgets a,
    .footer.bg-dark .footer__widgets p {
        color: #9D9E9E;
    }

    .footer.bg-dark .footer__bottom .copyright {
        color: #9D9E9E;
    }

    .footer.bg-dark .footer__bottom.top-divider {
        border-top-color: #555555;
    }

    /* Footer Widgets
    -------------------------------------------------------*/

    .footer__widgets {
        padding: 50px 0 30px 30px;
    }

    .footer__widgets .widget-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer__widgets a {
        color: #555;
        transition: all 300ms linear;
    }

    .footer__widgets a:hover {
        color: #323232;
    }

    @media only screen and (max-width: 991px) {
        .footer__widgets .row > div:not(:last-child) {
            margin-bottom: 60px;
        }
    }

    .widget-title {
        margin-bottom: 18px;
        font-size: 15px;
        font-weight: 500;
        position: relative;
    }

    .widget-links li {
        font-size: 13px;
    }

    .footer .logo {
        max-width: 170px;
        display: block;
    }
    .footer-top{
        padding: 80px 0 50px;
    }
    .footer .foot-links a {
        color: #222;
        padding-left: 15px;
        position: relative;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 15px;
        text-transform: capitalize;
    }

    .footer .foot-links a:last-of-type {
        margin-bottom: 0;
    }

    .footer .foot-links a:before {
        font-size: 17px;
        content: '\F2FB';
        font-family: "Material-Design-Iconic-Font";
        position: absolute;
        top: 2px;
        left: 0;
        line-height: 1;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
        color: #222;
    }

    .footer .foot-links a:hover {
        padding-left: 20px;
    }

    .footer .stores-icon a {
        width: 110px;
        display: inline-block;
    }
    .f-contact-detail{
        position: relative;
        padding-left: 30px;
        font-size: 14px;
    }
    .f-contact-detail i{
        left: 0;
        position: absolute;
        font-size: 20px;
        top: 2px;
        color: #000000;
    }
    .contact-info li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 15px;
        color: #222;
    }

    .contact-info li:last-of-type {
        margin-bottom: 0;
    }

    .contact-info li i {
        left: 0;
        top: 4px;
        position: absolute;
        color: #222;
    }

    .socials a {
        width: 35px;
        height: 35px;
        background: #585f66;
        border-radius: 50%;
        text-align: center;
        color: #fff !important;
        padding-top: 10px;
        font-size: 16px;
        margin-right: 10px;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }

    .socials a:hover {
        background-color: var(--main-color);
    }
    .f-contact-detail i {
        color: var(--main-color);
    }

</style>

<div class="bg--primary footer">
    <div class="container border-bottom">
        <div class="footer__widgets">
            <div class="row">

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget footer__about-us">
                        <a href="./" class="hover-logo d-inline-block">
                            <img src="{{ $global->logo_url }}" class="logo" style="max-height:35px">
                        </a>

                        <div class="socials mt-4">
                            @foreach ($defaultFrontDetail->social_links as $link)
                                @if (strlen($link['link']) > 0)
                                    <a href="{{ $link['link'] }}" class="zmdi zmdi-{{$link['name']}}" target="_blank">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div> <!-- end about us -->

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget widget-links">
                        <h5 class="widget-title">{{__('app.main')}}</h5>
                        <ul class="list-no-dividers">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">@lang('app.register')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="@if(\Request()->is('/')) #features @else {{ route('index').'#features' }} @endif">@lang('menu.features')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="@if(\Request()->is('/')) #pricing @else {{ route('index').'#pricing' }} @endif">@lang('menu.pricing')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">@lang('app.login')</a>
                                </li>
                            </ul>

                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget widget-links">
                        <h5 class="widget-title">{{__('app.others')}}</h5>
                        <ul class="navbar-nav ml-auto">
                            @foreach($footerSettings as $footerSetting)
                                <li class="nav-item active">
                                    <a class="nav-link" target="_blank" href="{{ route('page', $footerSetting->slug) }}">
                                        {{ $footerSetting->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">@lang('menu.contact')</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget widget-links">
                        <h5 class="widget-title">@lang('menu.contact')</h5>

                        <div class="socials mt-40">

                            <div class="f-contact-detail mt-20">
                                <i class="flaticon-email"></i>
                                <p class="mb-0">{{ $global->company_email }}</p>
                            </div>
                            @if($global->company_phone)
                                <div class="f-contact-detail mt-20">
                                    <i class="flaticon-call"></i>
                                    <p class="mb-0">{{ $global->company_phone }}</p>
                                </div>
                            @endif

                            <div class="f-contact-detail mt-20">
                                <i class="flaticon-placeholder"></i>
                                <p class="mb-0">{{ $global->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end container -->

    <div class="footer__bottom top-divider">
        <div class="container text-center ">
            <span class="copyright mr-3">
              {{ ucwords($frontDetail->footer_copyright_text) }}
            </span>
            {{-- <div class="input-group d-inline-flex lang-selector">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="zmdi zmdi-globe-alt"></i></span>
                </div>
                <select class="custom-select custom-select-sm" onchange="location = this.value;">
                    <option value="{{ route('front.language.lang', 'en') }}"
                            @if($locale == 'en') selected @endif>English
                    </option>
                    @foreach($languages as $language)
                        <option value="{{ route('front.language.lang', $language->language_code) }}"
                                @if($locale == $language->language_code) selected @endif>{{
                                    $language->language_name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

        </div>
    </div> <!-- end footer bottom -->
</div>