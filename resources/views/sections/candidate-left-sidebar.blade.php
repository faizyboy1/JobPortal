<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('candidate.dashboard') }}" class="brand-link">
        <img src="{{ $global->logo_url }}"
             alt="AdminLTE Logo"
             class="brand-image img-fluid">
    </a>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" id="sidebarnav" role="menu"
                data-accordion="false">

            {{-- 
            @if(!is_null($activePackage))
            --}}
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('candidate.dashboard') }}" class="nav-link {{ request()->is('candidate/dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon icon-speedometer"></i>
                            <p>
                                @lang('menu.dashboard')
                            </p>
                        </a>
                    </li>

                {{-- 
                @endif
                --}}
                <li class="nav-item">
                    <a href="{{ route('admin.report.index') }}" class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        <p>
                            @lang('app.reports')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.report.index') }}" class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        <p>
                            CV Builder
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview @if(\Request()->is('admin/settings/*') || \Request()->is('admin/profile'))active menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-settings"></i>
                        <p>
                            @lang('menu.settings')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{--
                        @if(!is_null($activePackage))
                        --}}
                            <li class="nav-item">
                                <a href="{{ route('candidate.profile.index') }}" class="nav-link {{ request()->is('candidate/profile*') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> @lang('menu.myProfile')</p>
                                </a>
                            </li>
                        {{--
                        @endif
                        --}}
                   

                    </ul>
                </li>

                {{--
                @if(!is_null($activePackage) && $activePackage->package->career_website)
                --}}
                    <li class="nav-header">@lang('app.miscellaneous')</li>
                    <li class="nav-item">
                        <a href="{{ jobOpenings($global->career_page_link) }}" target="_blank"
                           class="nav-link">
                            <i class="nav-icon fa fa-external-link"></i>
                            <p>@lang('app.careerWebsite')</p>
                        </a>
                    </li>
                    {{--
                    @endif
                --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

