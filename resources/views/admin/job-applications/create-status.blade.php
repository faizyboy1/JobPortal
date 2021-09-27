<div class="modal-header">
    <h4 class="modal-title">
        <i class="icon-plus"></i> @lang('modules.jobApplication.createStatus')
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
</div>
<div class="modal-body">
    <form id="createStatus" class="ajax-form" method="post">
        @csrf
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="d-block control-label">@lang('modules.jobApplication.statusName')</label>
                        <input type="text" id="status_name" name="status" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label class="d-block control-label">@lang('modules.jobApplication.statusColor')</label>
                    <div id="cp2" class="input-group">
                        <input type="text" class="form-control input-lg" name="status_color" value="#DD0F20"/>
                        <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label class="d-block control-label">@lang('modules.jobApplication.statusPosition')</label>
                    <select name="status_position" id="status_position" class="select2 form-control">
                        @foreach ($statuses as $status)
                            <option value="{{$status->position}}">{{'After '.ucwords($status->status)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group ">
                        <label class="d-block control-label required">@lang('app.slug')</label>
                        <input type="text"  id="slug" name="slug" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" class="btn btn-success" onclick="javascript:saveStatus();">@lang('app.submit')</button>
</div>

<script>
    $(function() {
        $('#cp2').colorpicker();
    });
    $('#status_name').keyup(function(){
                var text = $('#status_name').val();
                var slug = convertToSlug(text);
                $('#slug').val(slug);
            })
            function convertToSlug(Text)
            {
                return Text
                    .toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-')
                    ;
            }
</script>
