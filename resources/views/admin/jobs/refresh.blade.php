<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary">@lang('app.refreshjob')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editDate" class="ajax-form" method="post">
                @csrf
                <input type ="hidden" id = "hidden_id" name="id">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6  col-xs-12">
                                <div class="form-group">
                                    <label>@lang('app.startDate')</label>
                                    <input type="text" class="form-control" id="date-start" value="" name="start_date">
                                </div>
                            </div>

                            <div class="col-md-6  col-xs-12">
                                <div class="form-group chooseCandidate bootstrap-timepicker timepicker">
                                    <label>@lang('app.endDate')</label>
                                    <input type="text" class="form-control" id="date-end" name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                    @lang('app.save')
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@push('footer-script')
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>


<script>
    // Datepicker set
    $('#date-end').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
        minDate : new Date()
    });
    $('#date-start').bootstrapMaterialDatePicker({
        time: false,
        clearButton: true,
        minDate : new Date()
    }).on('change', function(e, date) {
        $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        $('#date-end').val(moment(date).add(1, 'month').format('YYYY-MM-DD'));
    });

    // Timepicker Set
    $('#scheduleTime').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true, // look it
        format: 'HH:mm',
        switchOnClick: true
    });
    //onclick to save form
    $('#save-form').click(function() {
        var id = $('#hidden_id').val();
        var url = "{{ route('admin.jobs.refreshDate',':id') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";
       
        $.easyAjax({
            url: url,
            container: '#editDate',
            type: "POST",
            redirect: true,
            data: $('#editDate').serialize(),
            success: function (response) {
                console.log(response);
                    if (response.status == 'success') {
                        $('#myModal').modal('hide');
                        window.location.reload();
                       
                    }
                }
        });
        
    });
</script>


@endpush