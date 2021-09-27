<div id="ModalLoginForm" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">@lang('modules.applicationSetting.formSettings')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form id="editSettings" class="ajax-form">
            @csrf
                        @method('PUT')
                    
                    <div class="form-group">
                        <label for="address">@lang('modules.applicationSetting.legalTermText')</label>
                        <div>
                            <textarea class="form-control" id="legal_term" name="legal_term" rows="15" placeholder="Enter text ..."></textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="card-title mb-4 text-primary">@lang('modules.applicationSetting.mailSettings')</h4>
                        <div>
                            <label style="margin-left: 0px">Send mail if candidate move to </label>
                            <div style="margin-left: -38px;">
                                <ul id="assetNameMenu">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                                @lang('app.save')
                            </button>
                            <button type="button" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('footer-script')
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.application-setting.update', $global->id)}}',
            container: '#editSettings',
            type: "POST",
            redirect: true,
            file: true
        })
        $('#ModalLoginForm').modal('toggle'); 
    return false;
    });
</script>

  
@endpush