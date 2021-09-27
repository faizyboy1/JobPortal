<div class="modal-header">
    <h4 class="modal-title">@lang('modules.jobApplication.documents')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <button id="addNewDoc" type="button" class="btn btn-sm btn-primary mb-3">
        @lang('app.addNew')
    </button>
    <form id="addDocument" class="ajax-form mb-3" action="{{ route('admin.documents.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="form-body">
            <input type="hidden" name="documentable_type" value="{{ $documentable_type }}">
            <input type="hidden" name="documentable_id" value="{{ $documentable_id }}">
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>@lang('modules.jobApplication.document.name')</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>@lang('modules.jobApplication.document.file')</label><br>
                        <input class="select-file" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf,.gif,.txt" id="file" type="file" name="file"><br>
                        <span>@lang('modules.jobApplication.document.fileNote')</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" id="create-document" class="btn btn-sm btn-success">@lang('app.add') <i class="fa fa-arrow-right"></i></button>
        </div>
    </form>
    <hr>
    <div class="table-responsive my-3">
        <table id="docTable" class="table table-bordered table-striped w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('app.name')</th>
                <th>@lang('app.action')</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
        <i class="fa fa-times"></i> @lang('app.close')
    </button>
</div>

<script>
    function resetForm() {
        $('#addDocument').find('#name').val('');
        $('#addDocument').find('#file').val('');
    }

    var docTable = $('#docTable').dataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: "{!! route('admin.documents.data', ['documentable_type' => $documentable_type, 'documentable_id' => $documentable_id]) !!}",
        language: languageOptions(),
        "fnDrawCallback": function (oSettings) {
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        order: [['1', 'ASC']],
        columns: [
            { data: 'DT_Row_Index', sortable:false, searchable: false },
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', width: '15%', searchable : false}
        ]
    });

    $('#addDocument').hide();

    $('#addNewDoc').click(function() {
        $('#addDocument').slideToggle();
    });

    $('#addDocument').submit(function(e) {
        e.preventDefault();

        const form = $(this);

        $.easyAjax({
            url: form.attr('action'),
            type: 'POST',
            container: '#addDocument',
            file: true,
            success: function (response) {
                if (response.status == 'success') {
                    docTable._fnDraw()
                    resetForm();
                }
            }
        })
    });
</script>