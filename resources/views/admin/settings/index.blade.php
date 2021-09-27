@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">

@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="company_name">@lang('modules.accountSettings.companyName')</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                   value="{{ $global->company_name }}">
                        </div>
                        <div class="form-group">
                            <label for="company_name">@lang('modules.accountSettings.companyUrlLink')</label>
                            <input type="text" class="form-control" id="company_slug" name="company_slug" value="{{ $global->career_page_link }}">
                            <input type="hidden" id="slug" value="{{ $global->career_page_link }}" name="slug">
                            <span class="text-success">@lang('modules.accountSettings.companyUrlLinkWillBe') </span> : <span class="font-weight-bold " style="border: none" id="slugValue">{{ $global->career_page_link }}</span>
                        </div>
                        <div class="form-group">
                            <label for="company_email">@lang('modules.accountSettings.companyEmail')</label>
                            <input type="email" class="form-control" id="company_email" name="company_email"
                                   value="{{ $global->company_email }}">
                        </div>
                        <div class="form-group">
                            <label for="company_phone">@lang('modules.accountSettings.companyPhone')</label>
                            <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                   value="{{ $global->company_phone }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('modules.accountSettings.companyWebsite')</label>
                            <input type="text" class="form-control" id="website" name="website"
                                   value="{{ $global->website }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('modules.accountSettings.companyLogo')</label>
                             <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="logo" class="dropify"
                                            data-default-file="{{ $global->logo_url }}"
                                        />
                                    </div>
                                </div>
                        </div>

                        @if(module_enabled('Subdomain'))
                            <div class="form-group">
                                <label><?php echo app('translator')->get('modules.frontCms.loginBackroundImage'); ?></label>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="login_background" class="dropify"
                                               data-default-file="{{ $global->login_background_image_url }}"
                                        />
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="address">@lang('modules.accountSettings.companyAddress')</label>
                            <textarea class="form-control" id="address" rows="5"
                                      name="address">{{ $global->address }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="address">@lang('modules.accountSettings.defaultTimezone')</label>
                            <select name="timezone" id="timezone" class="form-control select2 custom-select">
                                @foreach($timezones as $tz)
                                    <option @if($global->timezone == $tz) selected @endif>{{ $tz }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">@lang('modules.accountSettings.changeLanguage')</label>

                            <select class="form-control" name="locale">
                                @foreach($languageSettings as $language)
                                    <option value="{{ $language->language_code }}" @if($global->locale == $language->language_code) selected @endif  data-content='<span class="flag-icon flag-icon-{{ $language->language_code }}"></span> {{ $language->language_name }}'>{{ $language->language_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>


                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('modules.accountSettings.jobOpeningHeading')</label>
                            <input type="text" class="form-control" id="job_opening_title" name="job_opening_title"
                                   value="{{ $global->job_opening_title }}">
                        </div>

                        <div class="form-group">
                            <label for="address">@lang('modules.accountSettings.jobOpeningText')</label>
                            <textarea class="form-control summernote" id="job_opening_text" rows="5"
                                      name="job_opening_text">{{ $global->job_opening_text }}</textarea>
                        </div>




                        <button type="button" id="save-form"
                                class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset"
                                class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/speakingurl@14.0.1/speakingurl.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/slugify/src/slugify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>

    <script>
//        jQuery(function($) {
            $.slugify("Ätschi Bätschi"); // "aetschi-baetschi"
            $('#slug').slugify('#company_slug'); // Type as you slug

//            $("#slug-target").slugify("#slug-source", {
//                separator: '_' // If you want to change separator from hyphen (-) to underscore (_).
//            });
//        });
        $('#job_opening_text').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)

        });
        $('#company_slug').on('keyup change', function() {
            if ($('#slug').val() !== '' && $('#slug').val() !== undefined) {
                $('#slugValue').html($('#slug').val());
            } else {

            }
        });
        // For select 2
        $(".select2").select2();

        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });



        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.settings.update', $global->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>


@endpush
