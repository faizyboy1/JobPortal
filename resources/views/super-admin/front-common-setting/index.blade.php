@extends('layouts.app')

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('modules.frontCms.commonSettings')</h4>
                <form id="commonSettings" class="ajax-form mb-5">
                    @csrf
                    <div class="form-group">
                        <label>@lang('modules.frontCms.callToActionButton')</label>
                        <select name="call_to_action_button" id="call_to_action_button" class="form-control">
                            <option
                            @if($headerData->call_to_action_button == 'login') selected @endif
                             value="login">@lang('app.login')</option>
                            <option
                            @if($headerData->call_to_action_button == 'register') selected @endif
                            value="register">@lang('app.register')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('modules.frontCms.logo')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="input-file-now" name="logo" class="dropify" data-default-file="{{ $headerData->logo_url }}"  />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.loginBackroundImage')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="login_background_image" name="login_background_image" class="dropify" data-default-file="{{ $headerData->login_background_image_url }}"  />
                            </div>
                            <input type="hidden" name="remove_login_background" id="remove_login_background" value="no">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.registerBackroundImage')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="register_background_image" name="register_background_image" class="dropify" data-default-file="{{ $headerData->register_background_image_url }}"  />
                            </div>
                            <input type="hidden" name="remove_register_background" id="remove_register_background" value="no">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <div class="col-lg-3">
                                <label>@lang('modules.frontCms.showLoginInMenu')</label>
                                <select id="show_login_in_menu" class="form-control" name="show_login_in_menu">
                                    <option
                                    @if($headerData->show_login_in_menu == "1") selected @endif
                                    value="1">@lang('app.yes')</option>
                                    <option
                                    @if($headerData->show_login_in_menu == "0") selected @endif
                                    value="0">@lang('app.no')</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>@lang('modules.frontCms.showRegisterInMenu')</label>
                                <select id="show_register_in_menu" class="form-control" name="show_register_in_menu">
                                    <option
                                    @if($headerData->show_register_in_menu == "1") selected @endif
                                    value="1">@lang('app.yes')</option>
                                    <option
                                    @if($headerData->show_register_in_menu == "0") selected @endif
                                    value="0">@lang('app.no')</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>@lang('modules.frontCms.showLoginInHeader')</label>
                                <select id="show_login_in_header" class="form-control" name="show_login_in_header">
                                    <option
                                    @if($headerData->show_login_in_header == "1") selected @endif
                                    value="1">@lang('app.yes')</option>
                                    <option
                                    @if($headerData->show_login_in_header == "0") selected @endif
                                    value="0">@lang('app.no')</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>@lang('modules.frontCms.showRegisterInHeader')</label>
                                <select name="show_register_in_header" id="show_register_in_header" class="form-control">
                                    <option
                                    @if($headerData->show_register_in_header == "1") selected @endif
                                    value="1">@lang('app.yes')</option>
                                    <option
                                    @if($headerData->show_register_in_header == "0") selected @endif
                                    value="0">@lang('app.no')</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-4 mt-4">
                                <div class="example">
                                    <h5 class="box-title">@lang('modules.frontCms.themePrimaryColor')</h5>
                                    <input type="text" name="header_background_color" class="gradient-colorpicker form-control" autocomplete="off" value="{{ $headerData->header_background_color }}" />
                                </div>

                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="box-title">@lang('modules.frontCms.customCss')</h5>
                                <textarea name="custom_css" class="my-code-area" rows="20" style="width: 100%">@if(is_null($headerData->custom_css))/*Enter your custom css after this line*/@else {!! $headerData->custom_css !!} @endif</textarea>
                            </div>

                        </div>
                    </div>

                    <button type="button" id="save-common-form" class="btn btn-success waves-effect waves-light m-r-10">
                        @lang('app.save')
                    </button>
                    <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
    <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}"></script>

    <script src="{{ asset('assets/ace/ace.js') }}"></script>
    <script src="{{ asset('assets/ace/theme-twilight.js') }}"></script>
    <script src="{{ asset('assets/ace/mode-css.js') }}"></script>
    <script src="{{ asset('assets/ace/jquery-ace.min.js') }}"></script>

    <script>
        function init() {
            $('.my-code-area').ace({ theme: 'twilight', lang: 'css' })

            // Colorpicker
            $(".colorpicker").asColorPicker();
            $(".complex-colorpicker").asColorPicker({
                mode: 'complex'
            });
            $(".gradient-colorpicker").asColorPicker(
                // {
                //     mode: 'gradient'
                // }
            );

            var drEvent = $('.dropify').dropify({
                messages: {
                    default: '@lang("app.dragDrop")',
                    replace: '@lang("app.dragDropReplace")',
                    remove: '@lang("app.remove")',
                    error: '@lang('app.largeFile')'
                }
            });

            drEvent.on('dropify.afterClear', function(event, element){
            $('#remove_header_background').val('yes');
            });

            $('#contact_text').wysihtml5({
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": true, //Button which allows you to edit the generated HTML. Default false
                "link": true, //Button to insert a link. Default true
                "image": true, //Button to insert an image. Default true,
                "color": true, //Button to change color of font
                stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)
            });
        }

        init();

        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            changeForm(e.target);
        })
        $('#save-common-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.front-cms.updateCommonHeader")}}',
                container: '#commonSettings',
                type: "POST",
                file: true
            })
        })
    </script>
@endpush
