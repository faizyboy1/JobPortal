@extends('layouts.auth')

@section('content')
    <form action="{{ route('login') }}" id="loginform" method="post">
        @csrf

        @if (session('status'))
            <div class="alert alert-success m-t-10">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                   placeholder="@lang('auth.email')" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <input id="password" type="password" placeholder="@lang('auth.password')"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        @if($global->google_recaptcha_key)
            <div class="g-recaptcha" data-sitekey="{{ $global->google_recaptcha_key }}"></div>
        @endif
        <br>

        <div class="row">
            <div class="col-sm-6">
                <div class="checkbox icheck">
                    <label>
                        <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                            <input  type="checkbox" {{ old('remember') ? 'checked' : '' }}  name="remember_me" id="remember_me" class="flat-red"  style="position: absolute; opacity: 0;">
                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        @lang('auth.rememberMe')
                    </label>
                </div>
            </div>

            <div class="col-sm-6 text-right">
                <a href="#" id="to-recover">@lang('app.forgotPassword')</a>
            </div>

            <!-- /.col -->
            <div class="col-sm-12 mt-4">
                <button type="submit" id="save-form" class="btn btn-primary btn-block">@lang('auth.login')</button>
            </div>
            <!-- /.col -->
        </div>
        @if(!module_enabled('Subdomain'))
        <p class="mb-1 mt-4 text-center">
            @lang('app.dontHaveAccount')  <a href="{{ route('register') }}" id="to-recover">@lang('app.register')</a>
        </p>
            @endif


    </form>

    <form class="form-horizontal" method="post" id="recoverform" style="display: none"
          action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="form-group ">
            <div class="col-xs-12">
                <h3>@lang('app.recoverPassword')</h3>
                <p class="text-muted">@lang('app.enterEmailInstruction')</p>
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <input class="form-control" type="email" id="email" name="email" required=""
                       placeholder="@lang('auth.email')" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
                        type="submit">@lang('app.sendPasswordLink')</button>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p><a href="{{ route('login') }}" class="text-primary m-l-5"><b>@lang('auth.login')</b></a></p>
            </div>
        </div>
    </form>
@endsection
