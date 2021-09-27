@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@section('create-button')
    <a href="javascript:showNewTodoForm();" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="todo-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('app.title')</th>
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

    <script>
        function showNewTodoForm() {
            let url = "{{ route('admin.todo-items.create') }}"

            $.ajaxModal('#application-md-modal', url);
        }

        function showUpdateTodoForm(id) {
            let url = "{{ route('admin.todo-items.edit', ':id') }}"
            url = url.replace(':id', id);

            $.ajaxModal('#application-md-modal', url);
        }

        function updateTodoStatus(id) {
            const title = $('#status-'+id).data('title');
            let url = "{{route('admin.todo-items.update', ':id')}}"
            url = url.replace(':id', id);

            let data = {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                id: id,
                status: $('#status-'+id).val(),
                title: title
            }

            $.easyAjax({
                url: url,
                container: '#todo-table',
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 'success'){
                        $.unblockUI();
                        todoTable._fnDraw();
                    }
                }
            })
        }

        function deleteTodoItem(id) {
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
                    let url = "{{ route('admin.todo-items.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    let data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    }

                    $.easyAjax({
                        url,
                        data,
                        type: 'POST',
                        container: '#roleMemberTable',
                        success: function (response) {
                            if (response.status == 'success') {
                                $.unblockUI();
                                todoTable._fnDraw();
                            }
                        }
                    })
                }
            });
        }

        var todoTable = $('#todo-table').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: '{!! route('admin.todo-items.index') !!}',
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            order: [[0, 'DESC']],
            columns: [
                { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
                { data: 'title', name: 'title' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action'}
            ]
        });
        new $.fn.dataTable.FixedHeader( todoTable );

        $('body').on('click', '#create-todo-item', function () {

            $.easyAjax({
                url: "{{route('admin.todo-items.store')}}",
                container: '#createTodoItem',
                type: "POST",
                data: $('#createTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $.unblockUI();
                        todoTable._fnDraw();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });


        $('body').on('click', '#update-todo-item', function () {
            const id = $(this).data('id');
            let url = "{{route('admin.todo-items.update', ':id')}}"
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                container: '#editTodoItem',
                type: "POST",
                data: $('#editTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $.unblockUI();
                        todoTable._fnDraw();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });
    </script>
@endpush
