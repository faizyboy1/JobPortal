@extends('layouts.app') 

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush 

@section('create-button')
<a href="{{ route('superadmin.custom-modules.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.install') / @lang('app.update') @lang('app.module')</a>
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('menu.customModules')</h4>

                <div class="row">

                    <div class="col-md-12">

                        <ul class="list-group m-t-20" id="files-list">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>@lang('app.name')</strong>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <strong>Envato Purchase code</strong>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <strong>@lang('app.currentVersion')</strong>
                                    </div>
{{--                                                            <div class="col-md-2 text-right">--}}
{{--                                                                <strong>@lang('app.latestVersion')</strong>--}}
{{--                                                            </div>--}}
                                    <div class="col-md-3 text-right">
                                        <strong>@lang('app.status')</strong>
                                    </div>
{{--                                                            <div class="col-md-2 text-right">--}}
{{--                                                                <strong>@lang('app.action')</strong>--}}
{{--                                                            </div>--}}
                                </div>
                            </li>
                            @php
                                $count = 0;
                            @endphp
                            @forelse ($allModules as $key=>$module)

                                <li class="list-group-item" id="file-{{ $count++ }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{ $key }}
                                        </div>
                                        <div class="col-md-4 text-right">
                                            @if(in_array($module, $recruitPlugins))

                                                @if (config(strtolower($module).'.setting'))
                                                    @php
                                                        $settingInstance = config(strtolower($module).'.setting');

                                                        $fetchSetting = $settingInstance::first();
                                                    @endphp

                                                    @if (config(strtolower($module).'.verification_required'))
                                                    {!! $fetchSetting->purchase_code ?? '<a href="javascript:;" class="btn btn-success btn-sm btn-outline verify-module" data-module="'. strtolower($module).'" >'.__('app.verifyEnvato').'</a>' !!}
                                                    @endif
                                                @endif


                                            @endif


                                        </div>
                                        <div class="col-md-3 text-right">
                                            @if (config(strtolower($module).'.setting'))
                                                <label class="badge badge-info">{{ File::get($module->getPath() . '/version.txt') }}</label>
                                            @endif
                                        </div>
{{--                                                                <div class="col-md-2 text-right">--}}
{{--                                                                    @if (config(strtolower($module).'.setting'))--}}
{{--                                                                        <label class="label label-info">{{ File::get($module->getPath() . '/version.txt') }}</label>--}}
{{--                                                                    @endif--}}
{{--                                                                </div>--}}
                                        <div class="col-md-3 text-right">
                                            <div class="switchery-demo">
                                                <input type="checkbox" @if(in_array($module, $recruitPlugins)) checked @endif class="js-switch change-module-setting" data-size="small" data-module-name="{{ $module }}" />
                                            </div>

                                        </div>
{{--                                                                <div class="col-md-2 text-right">--}}
                                            {{-- @if (config(strtolower($module).'.setting'))
                                            <a href="" class="btn btn-success btn-sm btn-outline" data-file-no="{{ $module }}" >@lang('app.download') @lang('app.update') <i class="fa fa-download"></i></a>
                                            @endif --}}
{{--                                                                </div>--}}
                                    </div>
                                </li>
                            @empty
                                <div class="text-center">
                                    <div class="empty-space" style="height: 200px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i
                                                        class="icon-layers"></i>
                                            </div>
                                            <div class="title mb-3">@lang('messages.noModules')
                                            </div>
                                            <div class="subtitle">
                                                <a href="{{ route('superadmin.custom-modules.create') }}" class="btn btn-success btn-sm btn-outline"><i class="fa fa-refresh"></i> @lang('app.install') / @lang('app.update') @lang('app.module')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                        </ul>
                    </div>


                    @include('vendor.froiden-envato.update.plugins')
                </div>


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

    $('.change-module-setting').change(function () {
        var module = $(this).data('module-name');

        if($(this).is(':checked'))
            var moduleStatus = 'active';
        else
            var moduleStatus = 'inactive';

        var url = '{{route('superadmin.custom-modules.update', ':module')}}';
        url = url.replace(':module', module);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': module, 'status': moduleStatus, '_method': 'PUT', '_token': '{{ csrf_token() }}' }
        })
    });

    $('.verify-module').click(function () {
        var module = $(this).data('module');
        var url = '{{route('superadmin.custom-modules.show', ':module')}}';
        url = url.replace(':module', module);
        $('#modelHeading').html('Verify your purchase');
        $.ajaxModal('#application-lg-modal', url);
    })

</script>
<script>
    function validateCode() {
        $.easyAjax({
            type: 'POST',
            url: "{{ route('superadmin.custom-modules.verify-purchase') }}",
            data: $("#verify-form").serialize(),
            container: "#verify-form",
            messagePosition: 'inline'
        });
        return false;
    }
</script>



@endpush