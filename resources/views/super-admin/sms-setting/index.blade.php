@extends('layouts.app')
@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-primary">@lang('app.sms.nexmoCredential')</h4>
                    <form id="editSmsSettings" class="ajax-form">
                        <div id="alert"></div>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nexmo_status">@lang('app.sms.nexmoStatus')</label>

                            <div class="col-sm-4">
                                <div class="switchery-demo">
                                    <input id="nexmo_status" name="nexmo_status" type="checkbox"
                                           @if($credentials->nexmo_status == 'active') checked
                                           @endif value="active" class="js-switch change-language-setting"
                                           data-color="#99d683" data-size="small"
                                           data-setting-id="{{ $credentials->id }}" onchange="toggle('#nexmo-credentials');"/>
                                </div>
                            </div>
                        </div>
                        <div id="nexmo-credentials">
                            <div class="form-group">
                                <label for="nexmo_key">@lang("app.sms.nexmoKey")</label>
                                <input type="text" name="nexmo_key" id="nexmo_key"
                                        class="form-control"
                                        value="{{ $credentials->nexmo_key }}">
                            </div>

                            <div class="form-group">
                                <label for="nexmo_secret">@lang("app.sms.nexmoSecret")</label>
                                <input type="password" name="nexmo_secret" id="nexmo_secret"
                                        class="form-control"
                                        value="{{ $credentials->nexmo_secret }}">
                            </div>

                            <div class="form-group">
                                <label for="nexmo_from">@lang("app.sms.nexmoFrom")</label>
                                <input type="text" name="nexmo_from" id="nexmo_from"
                                        class="form-control"
                                        value="{{ $credentials->nexmo_from }}">
                            </div>
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
<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

    <script>
        function toggle(elementBox) {
            var elBox = $(elementBox);
            elBox.slideToggle();
        }

        $('#nexmo_status').is(':checked') ? $('#nexmo-credentials').show() : $('#nexmo-credentials').hide();

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });

        // Update Mail Setting
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('superadmin.sms-settings.update', $credentials->id)}}',
                container: '#editSmsSettings',
                type: "POST",
                redirect: true,
                messagePosition: "inline",
                data: $('#editSmsSettings').serialize(),
              })
        });

    </script>

@endpush