<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('zoom::modules.zoommeeting.editMeeting')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'editMeeting','class'=>'ajax-form','method'=>'POST']) !!}
        
    <input type="hidden" name ="id_field" id ="id_field"  value="{{$event->id}}" >
    <div class="row">
        <div class="col-md-12 ">
            <div class="form-group">
                <label>@lang('zoom::modules.zoommeeting.meetingName')</label>
                <p>{{$event->meeting_name}}</p>
            </div>
        </div>       

    </div>
    
    <div class="row">
        <div class="col-xs-12 ">
            <div class="form-group">
                <label>@lang('app.description')</label>
                <p>{{ $event->description ?? "--" }}</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                  <label class="control-label">@lang('zoom::modules.zoommeeting.meetingHost')</label>
                  <select class="select2 form-control" id="created_by_2" name="created_by">
                      @foreach($employees as $emp)
                          <option @if($emp->id == $event->created_by)
                              selected
                              @endif value="{{ $emp->id }}">{{ ucwords($emp->name) }}</option>
                      @endforeach
                  </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-3 ">
            <div class="form-group">
                <label class="required">@lang('zoom::modules.zoommeeting.startOn')</label>
                <input type="text" name="start_date" id="start_date" value="{{ $event->start_date_time->format($global->date_format) }}" class="form-control" autocomplete="none">
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="input-group bootstrap-timepicker timepicker">
                <label>&nbsp;</label>
                <input type="text" name="start_time"  value="{{ $event->start_date_time->format($global->time_format) }}"  id="start_time" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <label class="required">@lang('zoom::modules.zoommeeting.endOn')</label>
                <input type="text" name="end_date" id="end_date" value="{{ $event->end_date_time->format($global->date_format) }}" class="form-control" autocomplete="none">
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="input-group bootstrap-timepicker timepicker">
                <label>&nbsp;</label>
                <input type="text" name="end_time" id="end_time" value="{{ $event->end_date_time->format($global->time_format) }}" class="form-control">
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" id="sub" class="btn btn-success edit-meeting waves-effect waves-light">@lang('app.submit')</button>
</div>

<script src="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>
<script>
    $(function() {
        jQuery('#start_date, #end_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: '{{ $global->date_picker_format }}',
            
        })
        $('#start_time, #end_time').timepicker({
            @if($global->time_format == 'H:i')
            showMeridian: false,
            @endif
            
        });
        $("#created_by_2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        
        $('.edit-meeting').click(function () {
            var id = $("#id_field").val();
            var url = "{{ route('admin.zoom-meeting.updateOccurrence', ':id') }}";
                url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                container: '#editMeeting',
                type: "POST",
                data: $('#editMeeting').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        window.location.reload();
                    }
                }
            })
        });
       
    })
</script>
