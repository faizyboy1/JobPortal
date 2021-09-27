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
                {{-- <div class="form-group">
                    <select name="language_settings_id" class="form-control selectpicker" onchange="changeForm()" id="language-switcher">
                        @forelse ($activeLanguages as $language)
                        <option
                            value="{{ $language->id }}" data-content=' <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_code) }}'>{{ ucfirst($language->language_code) }}</option>
                        @empty
                        @endforelse
                    </select>
                </div> --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @forelse ($activeLanguages as $language)
                            <li class="nav-item">
                                <a
                                        class="nav-link @if($language->language_code == 'en') active @endif"
                                        id="{{$language->language_code}}-tab"
                                        data-toggle="tab"
                                        data-language-id="{{$language->id}}"
                                        href="#{{$language->language_code}}"
                                        role="tab"
                                        aria-controls="{{$language->language_code}}"
                                        aria-selected="true"
                                >
                                    <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_name) }}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                    <div class="tab-content" id="edit-form">
                        @include('super-admin.front-cms.edit-form', ['headerData' => $headerData])
                    </div>
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

        function changeForm(target) {
            $.easyAjax({
                url: "{{ route('superadmin.front-cms.changeForm') }}",
                container: '#editSettings',
                data: {
                    language_settings_id: $(target).data('language-id')
                },
                type: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#edit-form').html(response.view);
                        init();
                    }
                }
            })
        }

        $('body').on('click', '#save-form', function () {
            $.easyAjax({
                url: '{{route("superadmin.front-cms.updateHeader")}}',
                container: '#editSettings',
                type: "POST",
                file: true,
                data: {
                    language_settings_id: $('#editSettings').data('language-id')
                }
            })
        });
    </script>
@endpush
