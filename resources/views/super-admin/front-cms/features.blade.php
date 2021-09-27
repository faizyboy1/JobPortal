@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('menu.cmsFeatures')</h4>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <a href="javascript:;" id="add-feature" class="btn btn-success btn-sm"><i
                                        class="fa fa-plus"></i> @lang('app.add') @lang('app.feature')</a>
                        </div>
                    </div>

                    <form id="editSettings" class="ajax-form" style="display:none">
                        @csrf
                        <div class="form-group">
                            <select name="language" class="form-control selectpicker" id="language_switcher">
                                @forelse ($activeLanguages as $language)
                                <option
                                        value="{{ $language->id }}" data-content=' <span class="flag-icon  @if($language->language_code == 'en') flag-icon-us @else  flag-icon-{{ $language->language_code }} @endif"></span> {{ ucfirst($language->language_code) }}'>{{ ucfirst($language->language_code) }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('modules.frontCms.title')</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label>@lang('modules.frontCms.description')</label>
                            <textarea name="description" class="form-control" id="description" cols="30"
                                      rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('modules.frontCms.image')</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="file" id="input-file-now" name="image" class="dropify"
                                           data-default-file="{{ asset('assets/logo-not-found.png') }}"/>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset"
                                class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                    </form>
                    <table class="table table-bordered mt-2">
                        <thead>
                        <tr>
                            <th style="width: 20px">#</th>
                            <th>@lang('modules.frontCms.image')</th>
                            <th>@lang('modules.frontCms.title')</th>
                            <th>@lang('app.language')</th>
                            <th>@lang('app.action')</th>
                        </tr>

                        </thead>
                        <tbody>
                        @forelse ($features as $key=>$item)
                            <tr id="row-{{ $item->id }}">
                                <td>{{ $key+1 }}.</td>
                                <td><img src="{{ $item->image_url }}" class="img img-fluid img-size-50" alt=""></td>
                                <td>{{ ucfirst($item->title) }}</td>
                                <td>{{ ucfirst($item->language->language_name) }}</td>
                                <td>
                                    <a href="{{ route('superadmin.front-cms.editfeatures', $item->id) }}"
                                       class="btn btn-primary btn-circle" data-toggle="tooltip"
                                       data-original-title="@lang('app.edit')"><i class="fa fa-pencil"
                                                                                  aria-hidden="true"></i></a>

                                    <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                                       data-toggle="tooltip"
                                       data-row-id="{{ $item->id }}" data-original-title="@lang('app.delete')"><i
                                                class="fa fa-times" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @empty

                        @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>

    <script>
        var drEvent = $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });


        drEvent.on('dropify.afterClear', function (event, element) {
//           $('#remove_header_background').val('yes'); 
        });

        $('#add-feature').click(function () {
            $('#editSettings').toggle();
        })

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("superadmin.front-cms.savefeatures")}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $('body').on('click', '.sa-params', function () {
            var id = $(this).data('row-id');
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {

                    var url = "{{ route('superadmin.front-cms.deleteFeature',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                $('#row-' + id).remove();
                            }
                        }
                    });
                }
            });
        });

    </script>




@endpush