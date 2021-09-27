<div class="modal-header">
    <h4 class="modal-title">@lang('app.createNew') @lang('app.language')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="createLangForm" class="ajax-form" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('app.language') @lang('app.name')</label>
                    <input type="text" name="language_name" id="language_name" class="form-control form-control-lg" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('app.language') @lang('app.code')</label>
                    <input type="text" name="language_code" id="language_code" class="form-control form-control-lg" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('app.language') @lang('app.status')</label>

                    <select name="status" id="lang-status" class="form-control form-control-lg">
                        <option value="enabled">@lang('app.enable')</option>
                        <option value="disabled">@lang('app.disable')</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                    class="fa fa-check"></i> @lang('app.save')</button>
        </div>
    </form>
</div>

<script>
    $('#save-form').click(function () {
        const form = $('#createLangForm');

        $.easyAjax({
            url: '{{route('superadmin.language-settings.store')}}',
            container: '#createLangForm',
            type: "POST",
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#application-md-modal').modal('hide');
                    langTable._fnDraw();
                    if ($('#lang-status').val() == 'enabled') {
                        location.reload();
                    }
                }
            }
        })
    });
</script>
