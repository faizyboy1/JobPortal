@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
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
                            <label class="control-label col-sm-8">@lang('modules.linkedInSettings.status')</label>
                            <div class="col-sm-4">
                                <label>@lang('modules.linkedInSettings.activateLinkedinSignin')</label>
                                <div class="switchery-demo">
                                    <input type="checkbox" name="status"
                                           @if($linkedInSetting->linkedin == 'enable') checked
                                           @endif class="js-switch change-language-setting" />
                                </div>
                            </div>
                        </div>
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
                var status = 'disable'
            }
            else
            {
                var status = 'enable'
            }
            $.easyAjax({
                url: '{{route("admin.linkedin-settings.update", $linkedInSetting->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>
@endpush