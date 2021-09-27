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
                <h4 class="card-title">@lang('app.edit') @lang('menu.settings')</h4>

                <form id="editSettings" class="ajax-form">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="company_name">@lang('modules.accountSettings.companyName')</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $global->company_name }}">
                    </div>
                    <div class="form-group">
                        <label for="company_email">@lang('modules.accountSettings.companyEmail')</label>
                        <input type="email" class="form-control" id="company_email" name="company_email" value="{{ $global->company_email }}">
                    </div>
                    <div class="form-group">
                        <label for="company_phone">@lang('modules.accountSettings.companyPhone')</label>
                        <input type="tel" class="form-control" id="company_phone" name="company_phone" value="{{ $global->company_phone }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('modules.accountSettings.companyWebsite')</label>
                        <input type="text" class="form-control" id="website" name="website" value="{{ $global->website }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('modules.accountSettings.companyLogo')</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="input-file-now" name="logo" class="dropify" data-default-file="{{ $global->logo_url }}"  />
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="exampleInputPassword1" style="width: 100%">@lang('modules.accountSettings.numberDeleteAccountAutomatically')</label>

                        <div class="input-group-prepend">
                            <select name="hoursDays" class="form-control">
                               <option @if($global->delete_account_hour_day == 'hour') selected @endif value="hour"> @lang('app.hours')</option>
                               <option  @if($global->delete_account_hour_day == 'day') selected @endif  value="day">  @lang('app.days')</option>
                            </select>
                        </div>
                        <input type="number" min="0"  class="form-control"  value="{{ $global->delete_account_in }}" name="delete_account_in">
                    </div>

                    <div class="form-group">
                        <label for="address">@lang('modules.accountSettings.companyAddress')</label>
                        <textarea class="form-control" id="address" rows="5" name="address">{{ $global->address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="address">@lang('app.currency')</label>
                        <select name="currency_id" id="currency_id" class="form-control">
                            @foreach ($currencies as $item)
                                <option 
                                @if ($item->id == $global->currency_id)
                                    selected
                                @endif
                                value="{{ $item->id }}">{{ $item->currency_code.' ('.$item->currency_symbol.')'  }}</option>                                
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

                    <div class="form-group">
                        <label for="google_recaptcha_key">@lang('modules.accountSettings.googleRecaptchaStatus')</label>
                        <div class="col-sm-4">
                            <div class="switchery-demo">
                                <input id="google_recaptcha_status" name="google_recaptcha_status" type="checkbox"
                                       @if($global->google_recaptcha_status == 1) checked
                                       @endif value="on" class="js-switch change-language-setting"
                                       data-color="#99d683" data-size="small" onchange="toggle('#google-captcha')"/>
                            </div>
                        </div>

                        
                    </div>
                    <div id= "google-captcha">
                        <div class="form-group">
                            <label for="google_recaptcha_key">@lang('modules.accountSettings.googleRecaptchaKey')</label>
                            <input type="text" class="form-control" id="google_recaptcha_key" name="google_recaptcha_key"
                               value="{{ $global->google_recaptcha_key }}">
                        </div>
                        <div class="form-group">
                            <label for="google_recaptcha_key">@lang('modules.accountSettings.googleCaptchaSecret')</label>
                            <input type="text" class="form-control" id="google_recaptcha_secret" name="google_recaptcha_secret"
                               value="{{ $global->google_recaptcha_secret }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('modules.accountSettings.updateEnableDisable')
                            <a href="javascript:void(0)"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" data-original-title="@lang('modules.accountSettings.updateEnableDisableTest')"></i></a>
                        </label>

                        <div class="col-sm-4">
                            <div class="switchery-demo">
                                <input id="nexmo_status" name="system_update" type="checkbox"
                                       @if($global->system_update == 1) checked
                                       @endif value="on" class="js-switch change-language-setting"
                                       data-color="#99d683" data-size="small"/>
                            </div>
                        </div>
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
<script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
<script>
    $('[data-toggle="tooltip"]').tooltip()
    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());

    });
    function toggle(elementBox) {
            var elBox = $(elementBox);
            elBox.slideToggle();
        }
    $('#google_recaptcha_status').is(':checked') ? $('#google-captcha').show() : $('#google-captcha').hide();
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
                url: '{{route("superadmin.global-settings.update", $global->id)}}',
                container: '#editSettings',
                type: "POST",
               // redirect: true,
                file: true
            })
        });

</script>




@endpush