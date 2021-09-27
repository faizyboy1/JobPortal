@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('superadmin.dashboard.index') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropzone-master/dist/dropzone.css') }}">
    <style>
        .file-bg {
            height: 150px;
            overflow: hidden;
            position: relative;
        }

        .file-bg .overlay-file-box {
            opacity: .9;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            text-align: center;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('menu.customModules')</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('superadmin.custom-modules.index') }}"
                               class="btn btn-warning btn-sm btn-outline"><i class="fa fa-arrow-left"></i>
                                @lang('app.back')</a>

                            <div class="white-box">

                                <p class="text-danger m-b-10 font-13">
                                    @lang("messages.loginAgain")
                                </p>

                                <div class="row">

                                    <div class="col-md-12 m-t-20">
                                        <h4 class="box-title text-info">Step 1</h4>
                                        <form action="{{ route('superadmin.update-application.store') }}"
                                              class="dropzone"
                                              id="file-upload-dropzone">
                                            {{ csrf_field() }}

                                            <div class="fallback">
                                                <input name="file" type="file" multiple/>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-12 m-t-20" id="install-process">

                                    </div>

                                    <div class="col-md-12 m-t-20">
                                        <h4 class="box-title text-info">Step 2</h4>
                                        <h4 class="box-title">@lang('modules.update.moduleFile')</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group" id="files-list">


                                            @foreach (\Illuminate\Support\Facades\File::files($updateFilePath) as
                                            $key=>$filename)
                                                @if (\Illuminate\Support\Facades\File::basename($filename) != "modules_statuses.json" &&
                                                strpos(\Illuminate\Support\Facades\File::basename($filename) , 'auto') ===
                                                false)
                                                    <li class="list-group-item" id="file-{{ $key+1 }}">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                {{ \Illuminate\Support\Facades\File::basename($filename) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                Uploaded On:
                                                                {{ \Carbon\Carbon::parse(\Illuminate\Support\Facades\File::lastModified($filename))->format('jS F, Y g:i:s a')}}
                                                            </div>
                                                            <div class="col-md-4 text-right">

                                                                <button type="button"
                                                                        class="btn btn-success btn-sm install-files text-white"
                                                                        data-file-no="{{ $key+1 }}"
                                                                        data-file-path="{{ $filename }}">@lang('modules.update.install')
                                                                    <i class="fa fa-refresh"></i></button>

                                                                <button type="button"
                                                                        class="btn btn-danger btn-sm delete-files text-white"
                                                                        data-file-no="{{ $key+1 }}"
                                                                        data-file-path="{{ $filename }}">@lang('app.delete')
                                                                    <i
                                                                            class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>


                                </div>
                                <!--/row-->
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>





@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropzone-master/dist/dropzone.js') }}"></script>
    <script type="text/javascript">
        Dropzone.options.fileUploadDropzone = {
            paramName: "file",
            dictDefaultMessage: "Upload or drop the downloaded file here",
            accept: function (file, done) {

                done();
            },
            init: function () {
                this.on("success", function (file, response) {
                    var viewName = $('#view').val();
                    if (viewName == 'list') {
                        $('#files-list-panel ul.list-group').html(response.html);
                    } else {
                        $('#thumbnail').empty();
                        $(response.html).hide().appendTo("#thumbnail").fadeIn(500);
                    }
                    window.location.reload();
                })
            }
        };

        var updateAreaDiv = $('#update-area');
        var refreshPercent = 0;
        var checkInstall = true;

        function checkIfFileExtracted() {
            $.easyAjax({
                type: 'GET',
                url: '{!! route("admin.updateVersion.checkIfFileExtracted") !!}',
                success: function (response) {
                    checkInstall = false;
                    $('#download-progress').append("<br><i><span class='text-success'>Installed successfully. Reload page to see the changes.</span>.</i>");
                    window.location.reload();
                }
            });
        }

        $('.install-files').click(function () {
            $('#install-process').html('<div class="alert alert-info ">Installing...Please wait (This may take few minutes.)</div>');

            let filePath = $(this).data('file-path');
            $.easyAjax({
                type: 'POST',
                url: '{!! route("superadmin.custom-modules.store") !!}',
                data: {"_token": "{{ csrf_token() }}", filePath: filePath},
                success: function (response) {
                    if (response.status === 'success') {
                        $('#download-progress').append("<br><i><span class='text-success'>Installed successfully. Reload page to see the changes.</span>.</i>");
                        window.location.reload();
                    }
                    $('#install-process').html('');
                }
            });
        });

        $('.delete-files').click(function () {
            let filePath = $(this).data('file-path');
            let fileNumber = $(this).data('file-no');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {

                    $.easyAjax({
                        type: 'POST',
                        url: '{!! route("superadmin.update-application.deleteFile") !!}',
                        data: {"_token": "{{ csrf_token() }}", filePath: filePath},
                        success: function (response) {
                            $('#file-' + fileNumber).remove();
                        }
                    });
                }
            });
        });
    </script>
@endpush
