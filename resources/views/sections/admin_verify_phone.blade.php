@if ($smsSettings->nexmo_status == 'active')
    @if (!$user->mobile_verified && !session()->has('verify:request_id'))
        <form method="POST" class="ajax-form" id="request-otp-form">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label for="mobile">@lang('app.mobile')</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-row">
                            <div class="col-sm-2">
                                <select name="calling_code" id="calling_code" class="form-control selectpicker" data-live-search="true" >
                                    @foreach ($calling_codes as $code => $value)
                                        <option value="{{ $value['dial_code'] }}"
                                        @if ($user->calling_code)
                                            {{ $user->calling_code == $value['dial_code'] ? 'selected' : '' }}
                                        @endif>{{ $value['dial_code'] . ' - ' . $value['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}" autofocus />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="request-otp" class="btn btn-primary w-100">@lang('app.requestOTP')</button>
                    </div>
                </div>
            </div>
        </form>
    @elseif (session()->has('verify:request_id'))
        <form method="POST" class="ajax-form" id="verify-otp-form">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label for="otp">@lang('app.otp')</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP" autofocus autocomplete="off" />
                        <span>
                            <label class="text-danger mx-3" id="demo"></label>
                            <span class="attempts_left"></span>
                        </span>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="verify-otp" class="btn btn-primary w-100">@lang('app.verifyMobile')</button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="row">
            <div class="col-md-12">
                <label for="mobile">@lang('app.mobile')</label>
            </div>
            <div class="col-md-10">
                <input type="text" readonly class="form-control" value="{{ $user->mobile }}" />
                <span class="text-success ml-2">
                    @lang('app.verified')
                </span>
            </div>
            <div class="col-md-2">
                <button type="button" id="change-mobile" class="btn btn-primary w-100">@lang('app.changeMobileNumber')</button>
            </div>
        </div>

    @endif
@endif
