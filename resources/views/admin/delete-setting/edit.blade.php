@extends('layouts.app')

@push('head-script')

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
                            <label class="control-label col-sm-8">@lang('modules.company.deleteAccount')</label>
                            <div class="col-sm-4">
{{--                                <label>@lang('app.deleteAccount')</label>--}}
                                <div class="">
                                   @if(is_null($global->delete_account_at))
                                    <button type="button" id="deleteAccount" class="btn btn-danger"><i class="fa fa-times"></i> @lang('app.deleteAccount')</button>
                                   @else
                                    <button type="button" id="cancelAccountDelete" class="btn btn-info"><i class="fa fa-check"></i> @lang('app.cancelDeleteAccount')</button>
                                   @endif
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
    <script>

        $('body').on('click', '#deleteAccount', function(){
            var type = 'delete';
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.accountDeleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    var url = "{{ route('admin.settings.delete-account-store') }}";
                    var token = "{{ csrf_token() }}";
                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'POST', 'type': type},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                //table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
        $('body').on('click', '#cancelAccountDelete', function(){
            var type = 'cancel';
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.accountDeleteCancelWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.yes')",
                cancelButtonText: "@lang('app.no')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    var url = "{{ route('admin.settings.delete-account-store') }}";
                    var token = "{{ csrf_token() }}";
                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'POST', 'type': type},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                //table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush