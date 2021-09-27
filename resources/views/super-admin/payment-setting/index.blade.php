@extends('layouts.app')
@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
<style>
    .box-display{
        display: none;
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-primary">PayPal</h4>
                    <form id="editPaymentSettings" class="ajax-form">
                        <div id="alert"></div>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="paypal_status">@lang('app.paypal') @lang('app.status')</label>

                            <div class="col-sm-4">
                                <div class="switchery-demo">
                                    <input id="paypal_status" name="paypal_status" type="checkbox"
                                           @if($credentials->paypal_status == 'active') checked
                                           @endif 
                                           class="js-switch change-language-setting"
                                           data-color="#99d683" data-size="small"
                                           data-setting-id="{{ $credentials->id }}" onchange="toggle('#paypal-credentials')"
                                           />
                                </div>
                            </div>
                        </div>
                        <div id="paypal-credentials">
                            <div class="form-group" >
                                <label for="mail_username">@lang('app.clientid')</label>
                                <input type="text" class="form-control" id="paypal_client_id" name="paypal_client_id"
                                       value="{{ $credentials->paypal_client_id }}">
                            </div>
                            <div class="form-group"  id="paypal_secret_box">
                                <label for="mail_password">@lang('app.secret')</label>
                                <input type="text" class="form-control" id="paypal_secret" name="paypal_secret"
                                       value="{{ $credentials->paypal_secret }}">
                            </div>

                            <div class="form-group">
                                <label for="mail_from_name">@lang('app.webhook')</label>
                                <p class="text-bold">{{ route('verify-billing-ipn') }}</p>
                                <p class="text-info">(@lang('messages.addPaypalWebhookUrl'))</p>
                            </div>
                            <div class="form-group">
                                <label>@lang('app.selectEnvironment')</label>
                                <select class="form-control" name="paypal_mode" id="paypal_mode" data-style="form-control">
                                    <option value="sandbox" @if($credentials->paypal_mode == 'sandbox') selected @endif>Sandbox</option>
                                    <option value="live" @if($credentials->paypal_mode == 'live') selected @endif>Live</option>
                                </select>
                            </div>
                        </div>


                        <h4 class="card-title mb-4 text-success">Stripe</h4>
                        <hr>
                        <div class="form-group">
                            <label for="stripe_status">@lang('app.stripe') @lang('app.status')</label>

                            <div class="col-sm-4">
                                <div class="switchery-demo">
                                    <input id="stripe_status" name="stripe_status" type="checkbox"
                                           @if($credentials->stripe_status == 'active') checked
                                           @endif class="js-switch change-language-setting"
                                           data-color="#99d683" data-size="small"
                                           data-setting-id="{{ $credentials->id }}"
                                           onchange="toggle('#stripe-credentials');" />
                                </div>
                            </div>
                        </div>
                        <div id="stripe-credentials">
                            <div class="form-group">
                                <label for="api_key">Publishable Key</label>
                                <input type="text" class="form-control" id="api_key" name="api_key"
                                       value="{{ $credentials->api_key }}">
                            </div>
                            <div class="form-group">
                                <label for="api_secret">Secret Key</label>
                                <input type="text" class="form-control" id="api_secret" name="api_secret"
                                       value="{{ $credentials->api_secret }}">
                            </div>
                            <div class="form-group">
                                <label for="webhook_key">@lang('app.webhook')</label>
                                <input type="text" class="form-control" id="webhook_key" name="webhook_key"
                                       value="{{ $credentials->webhook_key }}">
                            </div>


                            <div class="form-group">
                                <label for="mail_from_name">@lang('app.webhook') @lang('app.url')</label>
                                <p class="text-bold">{{ route('save_webhook') }}</p>
                                <p class="text-info">(@lang('messages.addStripeWebhookUrl'))</p>
                            </div>
                        </div>
                            <h4 class="card-title mb-4 text-info">Razorpay </h4>
                        <hr>
                            <div class="form-group">
                                <label for="stripe_status">@lang('app.razorpay') @lang('app.status')</label>

                                <div class="col-sm-4">
                                    <div class="switchery-demo">
                                        <input id="razorpay_status" name="razorpay_status" type="checkbox"
                                               @if($credentials->razorpay_status == 'active') checked
                                               @endif class="js-switch change-language-setting"
                                               data-color="#99d683" data-size="small"
                                               data-setting-id="{{ $credentials->id }}"
                                               onchange="toggle('#razorpay-credentials');" />
                                    </div>
                                </div>
                            </div>

                            <div id="razorpay-credentials" @if($credentials->razorpay_status != 'active') class="box-display" @endif>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="">Razorpay Key</label>
                                        <input type="text" name="razorpay_key" id="razorpay_key"
                                               class="form-control" value="{{ $credentials->razorpay_key }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Razorpay Secret Key</label>
                                        <input type="text" name="razorpay_secret" id="razorpay_secret"
                                               class="form-control" value="{{ $credentials->razorpay_secret }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Razorpay Webhook Secret Key</label>
                                        <input type="text" name="razorpay_webhook_secret" id="razorpay_webhook_secret"
                                               class="form-control" value="{{ $credentials->razorpay_webhook_secret }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mail_from_name">@lang('app.webhook') @lang('app.url')</label>
                                    <p class="text-bold">{{ route('save_razorpay-webhook') }}</p>
                                    <p class="text-info">(@lang('messages.addRazorpayWebhookUrl'))</p>
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

        $('#paypal_status').is(':checked') ? $('#paypal-credentials').show() : $('#paypal-credentials').hide();
        $('#stripe_status').is(':checked') ? $('#stripe-credentials').show() : $('#stripe-credentials').hide();

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });

        // Update Mail Setting
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('superadmin.payment-settings.update', $credentials->id)}}',
                container: '#editPaymentSettings',
                type: "POST",
                redirect: true,
                messagePosition: "inline",
                data: $('#editPaymentSettings').serialize(),
              })
        });
    </script>

@endpush