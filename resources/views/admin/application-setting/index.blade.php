@extends('layouts.app')

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <h4 class="card-title mb-4 text-primary">@lang('modules.applicationSetting.formSettings')</h4>
                        </div>

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="address">@lang('modules.applicationSetting.legalTermText')</label>
                                <textarea class="form-control" id="legal_term" name="legal_term" rows="15" placeholder="Enter text ...">{!! $setting->legal_term !!}</textarea>
                            </div>

                        </div>
                        <hr>

                        <div class="col-md-12">
                            <h4 class="card-title mb-4 text-primary">@lang('modules.applicationSetting.mailSettings')</h4>
                        </div>

                        <div id="mail-setting" class="row">
                            <label style="margin-left: 10px">Send mail if candidate move to </label>
                            @forelse($settings->mail_setting as $key => $mailSetting)
                                <div class="form-group" style="margin-left: 20px">
                                    <label class="">
                                        <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative; margin-right: 5px">
                                            <input
                                                type="checkbox"
                                                @if ($mailSetting['status']) checked @endif
                                                value="{{$key}}"
                                                name="checkBoardColumn[]"
                                                class="flat-red columnCheck"
                                                style="position: absolute; opacity: 0;"
                                            >
                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                        </div>
                                        {{ ucwords($mailSetting['name']) }}
                                    </label>
                                </div>
                            @empty
                            @endforelse
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
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    })

    var jobDescription = $('#legal_term').wysihtml5({
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
            url: '{{route('admin.application-setting.update', $global->id)}}',
            container: '#editSettings',
            type: "POST",
            redirect: true,
            file: true
        })
    });
</script>

  
@endpush