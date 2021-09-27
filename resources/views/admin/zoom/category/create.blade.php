<style>
    .modal {
    overflow-x: hidden;
    overflow-y: auto;
}
</style>

<div class="modal-header">
    <h4 class="modal-title"><i class="icon-plus"></i> @lang('app.category')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
   
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('app.category')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $key=>$category)
                    <tr id="cat-{{ $category->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($category->category_name) }}</td>
                        <td><a href="javascript:;" data-cat-id="{{ $category->id }}" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('modules.message.noCategoryAdded')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {!! Form::open(['id'=>'createClientCategory','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                        <label class="required">@lang('app.add') @lang('app.category')</label>
                        <input type="text" name="category_name" id="category_name" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>

    $('.delete-category').click(function () {
        var id = $(this).data('cat-id');
        var url = "{{ route('admin.category.destroy',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, '_method': 'DELETE'},
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
                    $('#cat-'+id).fadeOut();
                    var options = [];
                    var rData = [];
                    rData = response.data;
                   
                    $.each(rData, function( index, value ) {
                        var selectData = '';
                        selectData = '<option value="'+value.id+'">'+value.category_name+'</option>';
                        
                        options.push(selectData);
                    });
                    $('#category_id_edit').html(options);
                    $('#category_id').html(options);
                    $('#categoryModal').modal('hide');
                }
            }
        });
    });

    $('#save-category').click(function () {
        $.easyAjax({
            url: '{{route('admin.category.store')}}',
            container: '#createClientCategory',
            type: "POST",
            data: $('#createClientCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                        var options = [];
                        var rData = [];
                        rData = response.data;
                        $.each(rData, function( index, value ) {
                            var selectData = '';
                            selectData = '<option value="'+value.id+'">'+value.category_name+'</option>';
                            options.push(selectData);
                        });
                        $('#category_id_edit').html(options);
                        $('#category_id').html(options);
                         $('#categoryModal').modal('hide');
                }
            }
        })
    });
</script>