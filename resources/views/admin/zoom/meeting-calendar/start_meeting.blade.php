<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $meeting->meeting_name }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta name="format-detection" content="telephone=no">
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
   

        <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.1/css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.1/css/react-select.css" />
    </head>
    <body oncontextmenu="return false;">
        <style type="text/css">
            .navbar {
                background-color: #171e28;
            }
            .navbar-header {
                padding: 7px 15px;
            }
            .navbar-form h4 {
                color: #ffffff;
            }

            .app-logo {
                max-height: 40px;
            }
        </style>

        @if($global->active_theme == 'custom')
            <style>
                @if($user->hasRole('admin'))
                    :root {
                        --header_color: {{ admin_theme()->header_color }};
                        --sidebar_color: {{ admin_theme()->sidebar_color }};
                        --link_color: {{ admin_theme()->link_color }};
                        --sidebar_text_color: {{ admin_theme()->sidebar_text_color }};
                    }
                @elseif($user->hasRole('employee'))
                    :root {
                        --header_color: {{ employee_theme()->header_color }};
                        --sidebar_color: {{ employee_theme()->sidebar_color }};
                        --link_color: {{ employee_theme()->link_color }};
                        --sidebar_text_color: {{ employee_theme()->sidebar_text_color }};
                    }
                @else
                    :root {
                        --header_color: {{ client_theme()->header_color }};
                        --sidebar_color: {{ client_theme()->sidebar_color }};
                        --link_color: {{ client_theme()->link_color }};
                        --sidebar_text_color: {{ client_theme()->sidebar_text_color }};
                    }
                @endif

                .navbar {
                    background-color: var(--sidebar_color);
                }
                .navbar-form h4 {
                    color: var(--sidebar_text_color);
                }
            </style>
        @endif



        <nav id="nav-tool" class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="{{ $global->logo_url }}" class="app-logo" alt="logo">
                </div>
                <div class="navbar-form navbar-right">
                    <h4>@lang('modules.zoommeeting.meetingName') : {{ $meeting->meeting_name }}</h4>
                </div>
            </div>
        </nav>
    
        <!-- import ZoomMtg dependencies -->
    <script src="https://source.zoom.us/1.9.1/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.1/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.1/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.1/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://source.zoom.us/1.9.1/lib/vendor/lodash.min.js"></script>

    <!-- import ZoomMtg -->
    <script src="https://source.zoom.us/zoom-meeting-1.9.1.min.js"></script>

    @php
        if (user()->hasRole('admin')) {
            $leaveUrl = route('admin.zoom-meeting.table-view');
        } elseif (user()->hasRole('employee')) {
            $leaveUrl = route('member.zoom-meeting.index');
        } else {
            $leaveUrl = route('client.zoom-meeting.index');
        }
    @endphp

    <script type="text/javascript">
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareWebSDK();

        var meetConfig = {
            apiKey: "{{ $zoomSetting->api_key }}",
            apiSecret: "{{ $zoomSetting->secret_key }}",
            meetingNumber: "{{ $meeting->meeting_id }}",
            userName: "{{ $user->name }}",
            passWord: "{{ $zoomMeeting->password }}",
            leaveUrl: "{{ $leaveUrl }}",
            role: {{ $user->id == $meeting->created_by ? 1 : 0 }}
        };
        var signature = ZoomMtg.generateSignature({
            meetingNumber: meetConfig.meetingNumber,
            apiKey: meetConfig.apiKey,
            apiSecret: meetConfig.apiSecret,
            role: meetConfig.role,
            success: function(res){
                console.log(res.result);
            }
        });
        ZoomMtg.init({
            leaveUrl: meetConfig.leaveUrl,
            isSupportAV: true,
            success: function () {
                ZoomMtg.join(
                    {
                        meetingNumber: meetConfig.meetingNumber,
                        userName: meetConfig.userName,
                        signature: signature,
                        apiKey: meetConfig.apiKey,
                        passWord: meetConfig.passWord,
                        success: function(res){
                            $('#nav-tool').hide();
                        },
                        error: function(res) {
                            console.log(res);
                        }
                    }
                );
            },
            error: function(res) {
                console.log(res);
            }
        });
    </script>
    </body>
</html>
