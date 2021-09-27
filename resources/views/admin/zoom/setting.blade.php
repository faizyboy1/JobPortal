@extends('layouts.app')
@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

<style>
    .field-icon {
        float: right;
        cursor: pointer;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
    .hide-box{
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
            {{-- <li><a href="{{ route('admin.notices.index') }}">@lang($pageTitle)</a></li> --}}
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
            <div class="card-body" aria-expanded="true">
                <div class="panel-body">
                    <form class="ajax-form" method="POST" id="createzoom">
                        @csrf
                        @method('PUT')
                        <div class="form-body">
                            <div class="mb-3 d-flex">
                                <div class="checkbox icheck">
                                    <label>
                                        <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false"
                                            style="position: relative;">
                                            <input type="checkbox" @if ($zoom->enable_zoom == 1) checked @endif name="enable_zoom"
                                                id="enable_zoom" class="flat-red"
                                                style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper"
                                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                        </div>

                                    </label>
                                </div>
                            <label class="required pl-2" style="margin-top:2px;">@lang('modules.zoomsetting.enableSetting')</label>
                            </div>
                            <div class="row setting-tab">
                                <div class="col-xs-12 col-md-12 ">
                                    <div class="form-group col-md-6 p-0">
                                        <label class="required">@lang('modules.zoomsetting.zoomapikey')</label>
                                        <input type="password" name="api_key" id="api_key" value="{{$zoom->api_key ?? ''}}" class="form-control">
                                        <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group col-md-6 p-0">
                                        <label class="required">@lang('modules.zoomsetting.zoomapisecret')</label>
                                        <input type="password" name="secret_key" id="secret_key" value="{{$zoom->secret_key ?? ''}}" class="form-control">
                                        <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>@lang('modules.zoomsetting.openZoomApp')</label>
                                        <div class="radio-list">
                                            <label class="radio-inline p-0 mb-0">
                                                <div class="radio radio-info">
                                                    <input type="radio" name="meeting_app" @if($zoom->meeting_app == 'zoom_app') checked @endif id="zoom_app" value="zoom_app">
                                                    <label for="zoom_app">@lang('app.yes')</label>
                                                </div>
                                            </label>
                                            <label class="radio-inline mb-0">
                                                <div class="radio radio-info">
                                                    <input type="radio" name="meeting_app" @if($zoom->meeting_app == 'in_app') checked @endif id="in_app" value="in_app">
                                                    <label for="in_app">@lang('app.no')</label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="mail_from_name">@lang('app.webhook')</label>
                                        <p class="text-bold">{{ route('zoom-webhook') }}</p>
                                        <p class="text-info">(@lang('modules.zoomsetting.webhookInfo'))</p>
                                    </div>
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
</div> <!-- .row -->
@endsection

@push('footer-script')
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function(html) {
var switchery = new Switchery(html, { size: 'medium' });
});
$('#enable_zoom').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
    $('#update-form').click(function() {
        var status = $(this).is(':checked') ? 1 : 0 ;
        var url = "{{route('admin.zoom-setting.update', $zoom->id)}}";
        $.easyAjax({
            url: url,
            container: '#createzoom',
            type: "POST",
            redirect: true,
            data: $('#createzoom').serialize(),
            success: function (response) {
                if (response.status == "success") {
                    location.reload();

                 }
            }
        })
    });
    $('#enable_zoom').on('ifChecked', function(event){
        $('.setting-tab').show();
    });
    $('#enable_zoom').on('ifUnchecked', function(event){
          $('.setting-tab').hide();
     });
               
    @if($zoom->enable_zoom == 1) 
    $('.setting-tab').show();
    @else
    $('.setting-tab').hide();
    @endif
  
</script>

@endpush