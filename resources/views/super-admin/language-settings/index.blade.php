@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush

@section('create-button')
    <a href="javascript:;" id="create-language" class="btn btn-dark btn-sm m-l-15">
        <i class="fa fa-plus-circle"></i> 
        @lang('app.createNew')
    </a>
    <a href="{{ url('/translations') }}" target="_blank" class="btn btn-warning btn-sm m-l-15">
        <i class="fa fa-cog"></i> 
        @lang('app.translations')
    </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="langTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.code')</th>
                                <th>@lang('app.status')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

    <script>
        var langTable = $('#langTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: '{!! route('superadmin.language-settings.index') !!}',
            language: languageOptions(),
            "fnDrawCallback": function( oSettings ) {
                // Switchery
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function () {
                    new Switchery($(this)[0], $(this).data());
                });

                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            order: [[1, 'ASC']],
            columns: [
                { data: 'DT_Row_Index'},
                { data: 'language_name', name: 'language_name' },
                { data: 'language_code', name: 'language_code' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' }
            ]
        });
        new $.fn.dataTable.FixedHeader( langTable );


        $('body').on('click', '.edit-language', function () {
            var id = $(this).data('row-id');
            var url = '{{ route('superadmin.language-settings.edit', ':id')}}';
            url = url.replace(':id', id);

            $('#modelHeading').html('@lang('app.edit') @lang('menu.language')');
            $.ajaxModal('#application-md-modal', url);
        });

        $('body').on('click', '#create-language', function () {
            var url = '{{ route('superadmin.language-settings.create') }}';

            $('#modelHeading').html('@lang('app.createNew') @lang('menu.language')');
            $.ajaxModal('#application-md-modal', url);
        });

        $('body').on('click', '.delete-language-row', function(){
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
            }, function(isConfirm){
                if (isConfirm) {
                    var url = "{{ route('superadmin.language-settings.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                // swal("Deleted!", response.message, "success");
                                langTable._fnDraw();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('change', '.change-language-setting', function () {
            var id = $(this).data('lang-id');

            if ($(this).is(':checked'))
                var status = 'enabled';
            else
                var status = 'disabled';

            var url = '{{route('superadmin.language-settings.changeStatus', ':id')}}';
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "POST",
                data: {'id': id, 'status': status, '_method': 'PUT', '_token': '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.status == 'success') {
                        langTable._fnDraw();
                    }
                }
            })
        });

    </script>
@endpush