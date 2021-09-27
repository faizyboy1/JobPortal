@extends('layouts.app')
@push('head-script')
<style>
    .d-none {
        display: none;
    }
</style>
@endpush
@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> @lang($pageTitle)</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li><a href="">@lang($pageTitle)</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->

</div>
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('zoom::modules.zoomsetting.setting')</h4>

                <form class="ajax-form" method="POST" id="createzoom">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6 ">
                                <div class="form-group">
                                    <label class="required">@lang('zoom::modules.zoomsetting.zoomapikey')</label>
                                    <input type="password" name="api_key" id="api_key" value="{{$zoom->api_key ?? ''}}" class="form-control">
                                    <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('zoom::modules.zoomsetting.zoomapisecret')</label>
                                    <input type="password" name="secret_key" id="secret_key" value="{{$zoom->secret_key ?? ''}}" class="form-control">
                                    <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label>@lang('zoom::modules.zoomsetting.openZoomApp')</label>
                                    <div class="radio-list">
                                        <label class="radio-inline p-0">
                                            <div class="radio radio-info">
                                                <input type="radio" name="meeting_app" @if($zoom->meeting_app == 'zoom_app') checked @endif id="zoom_app" value="zoom_app">
                                                <label for="zoom_app">@lang('app.yes')</label>
                                            </div>
                                        </label>
                                        <label class="radio-inline">
                                            <div class="radio radio-info">
                                                <input type="radio" name="meeting_app" @if($zoom->meeting_app == 'in_app') checked @endif id="in_app" value="in_app">
                                                <label for="in_app">@lang('app.no')</label>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                           

                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="mail_from_name">@lang('app.webhook')</label>
                                <p class="text-bold">{{ route('zoom-webhook') }}</p>
                                <p class="text-info">(@lang('zoom::modules.zoomsetting.webhookInfo'))</p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="form-actions">
                        <button type="button" id="update-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script>
    $('#update-form').click(function() {
        var url = "{{route('admin.zoom-setting.update', $zoom->id)}}";

        $.easyAjax({
            url: url,
            container: '#createzoom',
            type: "POST",
            redirect: true,
            data: $('#createzoom').serialize()
        })
    });
</script>

@endpush