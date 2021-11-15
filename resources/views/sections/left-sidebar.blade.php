<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
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
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon icon-speedometer"></i>
                            <p>
                                @lang('menu.dashboard')
                            </p>
                        </a>
                    </li>

                    @if(in_array("view_category", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.job-categories.index') }}" class="nav-link {{ request()->is('admin/job-categories*') ? 'active' : '' }}">
                                <i class="nav-icon icon-grid"></i>
                                <p>
                                    @lang('menu.jobCategories')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_skills", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.skills.index') }}" class="nav-link {{ request()->is('admin/skills*') ? 'active' : '' }}">
                                <i class="nav-icon icon-grid"></i>
                                <p>
                                    @lang('menu.skills')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_locations", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->is('admin/locations*') ? 'active' : '' }}">
                                <i class="nav-icon icon-location-pin"></i>
                                <p>
                                    @lang('menu.locations')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_jobs", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.jobs.index') }}" class="nav-link {{ request()->is('admin/jobs*') ? 'active' : '' }}">
                                <i class="nav-icon icon-badge"></i>
                                <p>
                                    @lang('menu.jobs')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_job_company", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.job-company.index') }}" class="nav-link {{ request()->is('admin/job-company*') ? 'active' : '' }}">
                                <i class="nav-icon icon-film"></i>
                                <p>
                                    @lang('modules.dashboard.departments')
                                </p>
                            </a>
                        </li>
                    @endif

                
                    @if(in_array("view_job_applications", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.job-applications.index') }}" class="nav-link {{ request()->is('admin/job-applications*') ? 'active' : '' }}">
                                <i class="nav-icon icon-user"></i>
                                <p>
                                    @lang('menu.jobApplications')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.applications-archive.index') }}" class="nav-link {{ request()->is('admin/applications-archive*') ? 'active' : '' }}">
                                <i class="nav-icon icon-drawer"></i>
                                <p>
                                    @lang('menu.candidateDatabase')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.job-onboard.index') }}" class="nav-link {{ request()->is('admin/job-onboard*') ? 'active' : '' }}">
                                <i class="nav-icon icon-user"></i>
                                <p>
                                    @lang('menu.jobOnboard')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_schedule", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.interview-schedule.index') }}" class="nav-link {{ request()->is('admin/interview-schedule*') ? 'active' : '' }}">
                                <i class="nav-icon icon-calendar"></i>
                                <p>
                                    @lang('menu.interviewSchedule')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(in_array("view_team", $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->is('admin/team*') ? 'active' : '' }}">
                                <i class="nav-icon icon-people"></i>
                                <p>
                                    @lang('menu.team')
                                </p>
                            </a>
                        </li>
                    @endif

                    @if($user->roles->count() > 0)
                        <li class="nav-item">
                            <a href="{{ route('admin.todo-items.index') }}" class="nav-link {{ request()->is('admin/todo-items*') ? 'active' : '' }}">
                                <i class="nav-icon icon-notebook"></i>
                                <p>
                                    @lang('menu.todoList')
                                </p>
                            </a>
                        </li>
                    @endif
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
                @if(in_array("view_schedule", $userPermissions))
                @if(isset($zoom_setting->enable_zoom) && $zoom_setting->enable_zoom == 1)
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.zoom-meeting.table-view') }}" class="nav-link">
                        <i class="fa fa-video-camera"></i>
                        <p> @lang('menu.zoomMeeting')</p>
                    </a>
                </li>
                @endif
                @endif
                {{--
                @if(!is_null($activePackage))
                --}}
                    <li class="nav-item has-treeview @if(\Request()->is('admin/subscribe*'))active menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon icon-settings"></i>
                            <p>
                                @lang('menu.subscription')
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.subscribe.index') }}" class="nav-link {{ request()->is('admin/subscribe*' && !request()->is('admin/subscribe/history')) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> @lang('menu.subscription')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.subscribe.history') }}" class="nav-link {{ request()->is('admin/subscribe/history') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> @lang('menu.history')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--
                    @endif
                    --}}

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
                                <a href="{{ route('admin.profile.index') }}" class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> @lang('menu.myProfile')</p>
                                </a>
                            </li>

                            @if(in_array("manage_settings", $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('admin/settings/settings') ? 'active' : '' }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>@lang('menu.businessSettings')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.application-setting.index') }}" class="nav-link {{ request()->is('admin/settings/application-setting') ? 'active' : '' }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>@lang('menu.applicationFormSettings')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.role-permission.index') }}" class="nav-link {{ request()->is('admin/settings/role-permission') ? 'active' : '' }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>@lang('menu.rolesPermission')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.theme-settings.index') }}" class="nav-link {{ request()->is('admin/settings/theme-settings') ? 'active' : '' }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>@lang('menu.themeSettings')</p>
                                    </a>
                                </li>
                                @if($linkedinGlobal->status == 'enable')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.linkedin-settings.index') }}" class="nav-link {{ request()->is('admin/settings/linkedin-settings') ? 'active' : '' }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>@lang('menu.linkedInSettings')</p>
                                        </a>
                                    </li>
                                @endif
                                @if(is_null($global->account_delete_at))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.settings.delete-account') }}" class="nav-link {{ request()->is('admin/settings/delete-account') ? 'active' : '' }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>@lang('app.deleteAccount')</p>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#" class="nav-link" id="rtl">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>RTL</p>
                                        </a>
                                    </li> --}}
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('admin.zoom-setting.index') }}" class="nav-link {{ request()->is('admin/settings/zoom-setting') ? 'active' : '' }}">
                                        <i class="fa fa-circle-o nav-icon"></i>

                                        <p> @lang('menu.zoomSetting')</p>
                                    </a>
                                </li>
                            @endif
                        {{--
                        @endif
                        --}}
                   

                    </ul>
                </li>

               
                @if($activePackage->package->career_website != "")
                    <li class="nav-header">@lang('app.miscellaneous')</li>
                    <li class="nav-item">
                        <a href="{{ jobOpenings($global->career_page_link) }}" target="_blank"
                           class="nav-link">
                            <i class="nav-icon fa fa-external-link"></i>
                            <p>@lang('app.careerWebsite')</p>
                        </a>
                    </li>
                @endif

               
                    <li class="nav-header">@lang('app.miscellaneous')</li>
                    <li class="nav-item">
                        <a href="{{ url('companies') }}" target="_blank"
                           class="nav-link">
                            <i class="nav-icon fa fa-external-link"></i>
                            <p>@lang('Companies')</p>
                        </a>
                    </li>
                

                
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
