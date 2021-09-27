<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('superadmin.dashboard.index') }}" class="brand-link">
        <img src="{{ $global->logo_url }}"
             alt="Logo"
             class="brand-image img-fluid">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" id="sidebarnav" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('superadmin.dashboard.index') }}" class="nav-link {{ request()->is('super-admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon icon-speedometer"></i>
                        <p>
                            @lang('menu.dashboard')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superadmin.company.index') }}" class="nav-link {{ request()->is('super-admin/company*') ? 'active' : '' }}">
                        <i class="nav-icon icon-film"></i>
                        <p>
                            @lang('menu.companies')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superadmin.packages.index') }}" class="nav-link {{ request()->is('super-admin/packages*') ? 'active' : '' }}">
                        <i class="nav-icon icon-layers"></i>
                        <p>
                            @lang('menu.packages')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superadmin.invoices.index') }}" class="nav-link {{ request()->is('super-admin/invoices*') ? 'active' : '' }}">
                        <i class="nav-icon icon-docs"></i>
                        <p>
                            @lang('app.invoices')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superadmin.superadmins.index') }}" class="nav-link {{ request()->is('super-admin/superadmins*') ? 'active' : '' }}">
                        <i class="nav-icon icon-user"></i>
                        <p>
                            @lang('app.superadmin')
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview @if(request()->is('super-admin/front-cms*') || request()->is('super-admin/icon-features') || request()->is('super-admin/client-feedbacks'))active menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-screen-desktop"></i>
                        <p>
                            @lang('menu.frontCms')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superadmin.front-cms.common') }}" class="nav-link {{ request()->is('super-admin/front-cms/common') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.common')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.front-cms.index') }}" class="nav-link {{ request()->is('super-admin/front-cms/index') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.cmsGeneral')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.front-cms.features') }}" class="nav-link {{ request()->is('super-admin/front-cms/features') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.cmsFeatures')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.icon-features.index') }}" class="nav-link {{ request()->is('super-admin/icon-features') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.iconFeatures')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.client-feedbacks.index') }}"
                               class="nav-link {{ request()->is('super-admin/client-feedbacks') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.clientFeedbacks')</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item has-treeview
                @if(\Request()->is('super-admin/global-settings') ||
                 \Request()->is('super-admin/smtp-settings') ||
                 \Request()->is('super-admin/currency-settings') ||
                 \Request()->is('super-admin/language-settings') ||
                 \Request()->is('super-admin/theme-settings') ||
                 \Request()->is('super-admin/footer-settings') ||
                 \Request()->is('super-admin/payment-settings') ||
                 \Request()->is('super-admin/sms-settings') ||
                 \Request()->is('super-admin/update-application') ||
                 \Request()->is('super-admin/linkedin-settings') ||
                 \Request()->is('super-admin/custom-modules') ||
                  \Request()->is('super-admin/profile')) active menu-open @endif
                        ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-settings"></i>
                        <p>
                            @lang('menu.settings')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superadmin.global-settings.index') }}" class="nav-link {{ request()->is('super-admin/global-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.settings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.profile.index') }}" class="nav-link {{ request()->is('super-admin/profile') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.myProfile')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.smtp-settings.index') }}" class="nav-link {{ request()->is('super-admin/smtp-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.smtpSetting')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.currency-settings.index') }}" class="nav-link {{ request()->is('super-admin/currency-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>{{ __('app.currency').' '.__('menu.settings') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.language-settings.index') }}" class="nav-link {{ request()->is('super-admin/language-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('app.language') @lang('menu.settings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.theme-settings.index') }}" class="nav-link {{ request()->is('super-admin/theme-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.themeSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.footer-settings.index') }}" class="nav-link {{ request()->is('super-admin/footer-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.footerSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.payment-settings.index') }}" class="nav-link {{ request()->is('super-admin/payment-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.paymentSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.sms-settings.index') }}" class="nav-link {{ request()->is('super-admin/sms-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.smsSettings')</p>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('superadmin.custom-modules.index') }}" class="nav-link {{ request()->is('super-admin/custom-modules') ? 'active' : '' }}">--}}
{{--                                <i class="fa fa-circle-o nav-icon"></i>--}}
{{--                                <p>@lang('menu.customModules')</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        @if($global->system_update == 1)
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('superadmin.update-application.index') }}" class="nav-link {{ request()->is('super-admin/update-application') ? 'active' : '' }}">--}}
{{--                                    <i class="fa fa-circle-o nav-icon"></i>--}}
{{--                                    <p>@lang('menu.updateApplication')</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('superadmin.linkedin-settings.index') }}" class="nav-link {{ request()->is('super-admin/linkedin-settings') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.linkedInSettings')</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link" id="rtl">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>RTL</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="nav-header">@lang('app.miscellaneous')</li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" target="_blank" class="nav-link {{ request()->is('super-admin/global-settings') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-external-link"></i>
                        <p>@lang('app.frontWebsite')</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>