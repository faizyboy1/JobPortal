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
                <h4 class="card-title">@lang('menu.frontCms') @lang('menu.settings')</h4>

                <form id="editSettings" class="ajax-form">
                    @csrf

                    <div class="form-group">
                        <label>@lang('modules.frontCms.title')</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $headerData->title }}">
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.description')</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="4">{!! $headerData->description !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('modules.frontCms.callToActionTitle')</label>
                        <input class="form-control" id="call_to_action_title" name="call_to_action_title" value="{{ $headerData->call_to_action_title }}">
                    </div>
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
                        <label>@lang('modules.frontCms.contactText')</label>
                        <textarea name="contact_text" id="contact_text" class="form-control" cols="30" rows="6">{!! $headerData->contact_text !!}</textarea>
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
                        <label>@lang('modules.frontCms.headerImage')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="header_image" name="header_image" class="dropify" data-default-file="{{ $headerData->header_image_url }}"  />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.frontCms.headerBackroundImage')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="header_backround_image" name="header_backround_image" class="dropify" data-default-file="{{ $headerData->header_backround_image_url }}"  />
                            </div>
                            <input type="hidden" name="remove_header_background" id="remove_header_background" value="no">
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

                    <h4 class="card-title">@lang('modules.frontCms.seoSettings')</h4>
                    <div class="form-group">
                        <label for="meta_title" class="control-label">@lang('modules.frontCms.metaTitle')</label>
                        <input class="form-control" id="meta_title" name="meta_details[title]" value="{{ $headerData->meta_details['title'] }}">
                    </div>
                    <div class="form-group">
                        <label for="meta_description" class="control-label">@lang('modules.frontCms.metaDescription')</label>
                        <textarea name="meta_details[description]" id="meta_description" class="form-control" cols="30" rows="3">{!! $headerData->meta_details['description'] !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords" class="control-label">@lang('modules.frontCms.metaKeywords')</label>
                        <textarea name="meta_details[keywords]" id="meta_keywords" class="form-control" cols="30" rows="3">{!! $headerData->meta_details['keywords'] !!}</textarea>
                    </div>

                    <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
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
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>

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



        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.front-cms.updateHeader")}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

</script>




@endpush
