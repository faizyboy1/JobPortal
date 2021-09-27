@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')
                        <div id="alert">
                            @if($smtpSetting->mail_driver =='smtp')
                                @if($smtpSetting->verified)
                                    <div class="alert alert-success">{{__('messages.smtpSuccess')}}</div>
                                @else
                                    <div class="alert alert-danger">{{__('messages.smtpError')}}</div>
                                @endif
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="name">@lang('app.mailDriver')</label>
                            <div class="form-group">
                                <label class="radio-inline"><input type="radio"
                                                                   class="checkbox"
                                                                   onchange="getDriverValue(this);"
                                                                   value="mail"
                                                                   @if($smtpSetting->mail_driver == 'mail') checked
                                                                   @endif name="mail_driver">Mail</label>
                                <label class="radio-inline pl-lg-2"><input type="radio"
                                                                           onchange="getDriverValue(this);"
                                                                           value="smtp"
                                                                           @if($smtpSetting->mail_driver == 'smtp') checked
                                                                           @endif name="mail_driver">SMTP</label>


                            </div>
                        </div>
                        <div id="smtp_div">
                            <div class="form-group">
                                <label for="email">@lang('app.mailHost')</label>
                                <input type="email" class="form-control" id="mail_host" name="mail_host"
                                       value="{{ $smtpSetting->mail_host }}">
                            </div>
                            <div class="form-group">
                                <label for="mail_port">@lang('app.mailPort')</label>
                                <input type="text" class="form-control" id="mail_port" name="mail_port"
                                       value="{{ $smtpSetting->mail_port }}">
                            </div>
                            <div class="form-group">
                                <label for="mail_username">@lang('app.mailUsername')</label>
                                <input type="text" class="form-control" id="mail_username" name="mail_username"
                                       value="{{ $smtpSetting->mail_username }}">
                            </div>
                            <div class="form-group">
                                <label for="mail_password">@lang('app.mailPassword')</label>
                                <input type="password" class="form-control" id="mail_password" name="mail_password"
                                       value="{{ $smtpSetting->mail_password }}">
                            </div>
                            <div class="form-group">
                                <label for="mail_from_email">@lang('app.mailEncryption')</label>
                                <select class="form-control" name="mail_encryption"
                                        id="mail_encryption">
                                    <option value="tls" @if($smtpSetting->mail_encryption == 'tls') selected @endif>
                                        @lang('app.tls')
                                    </option>
                                    <option value="ssl" @if($smtpSetting->mail_encryption == 'ssl') selected @endif>
                                        @lang('app.ssl')
                                    </option>
                                    <option value="none" @if($smtpSetting->mail_encryption == null) selected @endif>
                                        @lang('app.none')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_from_name">@lang('app.mailFromName')</label>
                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                   value="{{ $smtpSetting->mail_from_name }}">
                        </div>
                        <div class="form-group">
                            <label for="mail_from_email">@lang('app.mailFromEmail')</label>
                            <input type="email" class="form-control" id="mail_from_email" name="mail_from_email"
                                   value="{{ $smtpSetting->mail_from_email }}">
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
    <script>
        // Update Mail Setting

        $('#save-form').click(function () {


            $.easyAjax({
                url: '{{route('superadmin.smtp-settings.update', $smtpSetting->id)}}',
                type: "POST",
                container: '#editSettings',
                messagePosition: "inline",
                data: $('#editSettings').serialize(),
                success: function (response) {
                    if (response.status == 'error') {
                        $('#alert').prepend('<div class="alert alert-danger">{{__('messages.smtpError')}}</div>')
                    } else {
                        $('#alert').show();
                    }
                }
            })
        });

        $('#send-test-email').click(function () {
            $('#testMailModal').modal('show')
        });
        $('#send-test-email-submit').click(function () {
            $.easyAjax({
                url: '{{route('superadmin.smtp-settings.sendTestEmail')}}',
                type: "GET",
                messagePosition: "inline",
                container: "#testEmail",
                data: $('#testEmail').serialize()

            })
        });


        function getDriverValue(sel) {
            if (sel.value == 'mail') {
                $('#smtp_div').hide();
                $('#alert').hide();
            } else {
                $('#smtp_div').show();
                $('#alert').show();
            }
        }

        @if ($smtpSetting->mail_driver == 'mail')
        $('#smtp_div').hide();
        $('#alert').hide();
        @endif
    </script>

@endpush