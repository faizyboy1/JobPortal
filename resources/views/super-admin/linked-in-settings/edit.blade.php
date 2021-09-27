@extends('layouts.app') @push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('app.edit') @lang('menu.linkedInSettings')</h4>
                    @if($httpsContains)
                        <form id="editSettings" class="ajax-form">
                            @csrf @method('PUT')
                            <div class="form-group">
                                <label class="control-label col-sm-8">@lang('modules.linkedInSettings.status')</label>
                                <div class="col-sm-4">
                                    <div class="switchery-demo">
                                        <input type="checkbox" name="status"
                                               @if($linkedInSetting->status == 'enable') checked
                                               @endif class="js-switch change-language-setting" />
                                    </div>
                                </div>
                            </div>
                            <div class="linkedInSettings @if($linkedInSetting->status == 'disable') hide
                                               @endif">
                                <div class="form-group">
                                    <label for="company_name">@lang('modules.linkedInSettings.client_id')</label>
                                    <input type="text" class="form-control" id="client_id" name="client_id" value="{{ $linkedInSetting->client_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_email">@lang('modules.linkedInSettings.client_secret')</label>
                                    <input type="email" class="form-control" id="client_secret" name="client_secret" value="{{ $linkedInSetting->client_secret }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_phone">@lang('modules.linkedInSettings.callback_url')</label>
                                    <input type="tel" class="form-control" readonly id="callback_url" name="callback_url" value="{{ $linkedInSetting->callback_url }}">
                                </div>
                                <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                                    @lang('app.save')
                                </button>
                                <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                            </div>
                        </form>
                        @else
                        <label class="control-label color--error col-sm-8">@lang('modules.linkedInSettings.sslError')</label>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

    <script>

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });

        $('.change-language-setting').change(function () {
                $('.linkedInSettings').toggleClass('hide');
            if (!$(this).is(':checked'))
            {
                $.easyAjax({
                    url: '{{route("superadmin.updateStatus", $linkedInSetting->id)}}',
                    container: '#editSettings',
                    type: "GET",
                    redirect: true,
                    file: true
                })
            }
        });

    </script>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.linkedin-settings.update", $linkedInSetting->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>
@endpush