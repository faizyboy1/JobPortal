@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <form action="" class="ajax-form" id="createForm" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="example">
                                    <h5 class="box-title">@lang('modules.themeSettings.themePrimaryColor')</h5>
                                    <input type="text" name="primary_color" class="gradient-colorpicker form-control" autocomplete="off" value="{{ $adminTheme->primary_color }}" />
                                </div>

                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="box-title">@lang('modules.themeSettings.adminPanelCustomCss')</h5>
                                <textarea name="admin_custom_css" class="my-code-area" rows="20" style="width: 100%">@if(is_null($adminTheme->admin_custom_css))/*Enter your custom css after this line*/@else {!! $adminTheme->admin_custom_css !!} @endif</textarea>

                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="box-title">@lang('modules.themeSettings.frontSiteCustomCss')</h5>
                                <textarea name="front_custom_css" class="my-code-area" rows="20" style="width: 100%">@if(is_null($adminTheme->front_custom_css))/*Enter your custom css after this line*/@else {!! $adminTheme->front_custom_css !!} @endif</textarea>

                            </div>

                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.background') @lang('app.image')</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                                   data-default-file="{{ $adminTheme->background_image_url }}"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="control-label">@lang('app.enableRtl')
                                 </label>
                                <div class="switchery-demo">
                                    <input type="checkbox" id="rtl" name="rtl"
                                        @if($adminTheme->rtl == true) checked
                                    @endif class="js-switch rtl" data-color="#00c292"
                                    data-secondary-color="#f96262"/>
                                </div>
                             </div>

                            <div class="col-md-12 mt-4">
                                <button class="btn btn-success" id="save-form" type="button"><i class="fa fa-check"></i> @lang('app.save')</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}"></script>

    <script src="{{ asset('assets/ace/ace.js') }}"></script>
    <script src="{{ asset('assets/ace/theme-twilight.js') }}"></script>
    <script src="{{ asset('assets/ace/mode-css.js') }}"></script>
    <script src="{{ asset('assets/ace/jquery-ace.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

    <script>
         // Switchery
         var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());

    });

        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

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

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.theme-settings.store')}}',
                container: '#createForm',
                type: "POST",
                file: true,
                redirect: true
            })
        });
        //rtl
        $('.rtl').change(function () {
        var rtl  = $('.rtl').is(':checked');
        $.easyAjax({
            url: '{{route('admin.theme-settings.rtlTheme')}}',
            type: "POST",
            data: {'_token': '{{ csrf_token() }}', 'rtl': rtl}
        })
        return false;
    });
    </script>
@endpush