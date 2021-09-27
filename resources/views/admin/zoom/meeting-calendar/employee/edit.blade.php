<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('zoom::modules.zoommeeting.editMeeting')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'editMeeting','class'=>'ajax-form','method'=>'POST']) !!}
                @method('PUT')
    <input type="hidden" name ="id_field" id ="id_field"  value="{{$event->id}}" >
    <div class="row">
        <div class="col-md-10 ">
            <div class="form-group">
                <label class="required">@lang('zoom::modules.zoommeeting.meetingName')</label>
                <input type="text" name="meeting_title" id="meeting_title" value="{{$event->meeting_name}}" class="form-control">
            </div>
        </div>
        
        <div class="col-md-2 ">
            <div class="form-group">
                <label>@lang('modules.sticky.colors')</label>
                <select id="color-selector" name="label_color">
                    <option value="bg-info" {{$event->label_color == "bg-info" ? 'selected' : ''}}  data-color="#5475ed" >Blue</option>
                    <option value="bg-warning" {{$event->label_color == "bg-warning" ? 'selected' : ''}} data-color="#f1c411">Yellow</option>
                    <option value="bg-purple" {{$event->label_color == "bg-purple" ? 'selected' : ''}} data-color="#ab8ce4">Purple</option>
                    <option value="bg-danger" {{$event->label_color == "bg-danger" ? 'selected' : ''}} data-color="#ed4040">Red</option>
                    <option value="bg-success" {{$event->label_color == "bg-success" ? 'selected' : ''}} data-color="#00c292">Green</option>
                    <option value="bg-inverse" {{$event->label_color == "bg-inverse" ? 'selected' : ''}} data-color="#4c5667">Grey</option>
                </select>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-xs-12 ">
            <div class="form-group">
                <label>@lang('zoom::modules.zoommeeting.description')</label>
                <textarea name="description"  id="description" class="form-control">{{ ucfirst($event->description) }}</textarea>
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
    <div class="row">
        <div class="col-xs-12" id="member-attendees">
            <div class="form-group">
                <label class="col-xs-3 m-t-10">@lang('zoom::modules.meetings.addEmployees')</label>
                <div class="col-xs-7">
                    <div class="checkbox checkbox-info">
                        <input id="edit-all-employees" name="all_employees" value="true" type="checkbox">
                        <label for="edit-all-employees">@lang('zoom::modules.meetings.allEmployees')</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
            
            <select id="employee_ids" class="select2 m-b-10 select2-multiple " multiple="multiple"
                        data-placeholder="@lang('zoom::modules.message.chooseMember')" name="employee_id[]"> 
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{in_array($emp->id, $event->attendees->pluck('id')->toArray())  ? 'selected' : ''}}>{{ ucwords($emp->name) }}
                        </option>
                    @endforeach
            </select>
            
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12"  id="client-attendees">
            <div class="form-group">
                <label class="col-xs-3 m-t-10">@lang('zoom::modules.meetings.addClients')</label>
                <div class="col-xs-7">
                    <div class="checkbox checkbox-info">
                        <input id="edit-all-clients" name="all_clients" value="true"
                                type="checkbox">
                        <label for="edit-all-clients">@lang('zoom::modules.meetings.allClients')</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <select id="client_ids" class="select2 m-b-10 select2-multiple " multiple="multiple"
                        data-placeholder="@lang('zoom::modules.message.selectClient')" name="client_id[]">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{in_array($client->id, $event->attendees->pluck('id')->toArray())  ? 'selected' : ''}}>{{ ucwords($client->name) }}</option>
                        @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <div class="m-b-10">
                    <label class="control-label">@lang('zoom::modules.zoommeeting.hostVideoStatus')</label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" name="host_video" id="edit-host_video1" value="1" {{ $event->host_video ? "checked" : "" }}>
                    <label for="edit-host_video1" class=""> @lang('app.enable') </label>
                </div>
                <div class="radio radio-inline ">
                    <input type="radio" name="host_video" id="edit-host_video2" value="0"{{ !$event->host_video ? "checked" : "" }}>
                    <label for="edit-host_video2" class=""> @lang('app.disable') </label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="m-b-10">
                    <label class="control-label">@lang('zoom::modules.zoommeeting.participantVideoStatus')</label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" name="participant_video" id="edit-participant_video1" value="1" {{ $event->participant_video ? "checked" : "" }}>
                    <label for="edit-participant_video1" class=""> @lang('app.enable') </label>
                </div>
                <div class="radio radio-inline ">
                    <input type="radio" name="participant_video" id="edit-participant_video2" value="0" {{ !$event->participant_video ? "checked" : "" }}>
                    <label for="edit-participant_video2" class=""> @lang('app.disable') </label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                  <label class="control-label">@lang('zoom::modules.zoommeeting.meetingHost')</label>
                  <select class="select2 form-control" id="created_by" name="created_by">
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
        <div class="form-group">
            <div class="col-xs-6">
                <div class="checkbox checkbox-info">
                    <input id="edit-send_reminder" name="send_reminder" value="1" type="checkbox" {{ ($event->send_reminder)? "checked" : "" }}>
                    <label for="edit-send_reminder">@lang('zoom::modules.zoommeeting.reminder')</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="edit-reminder-fields" style="display: none;">
        <div class="col-xs-6 col-md-3">
            <div class="form-group">
                <label>@lang('zoom::modules.zoommeeting.remindBefore')</label>
                <input type="number" min="1" value="{{$event->remind_time}}" name="remind_time" id="remind_time" class="form-control">
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group">
                <label>&nbsp;</label>
                
                <select name="remind_type" id="remind_type" class="form-control">
                    <option value="day" {{$event->remind_type == "day" ? 'selected' : ''}}>@lang('app.day')</option>
                    <option value="hour" {{$event->remind_type == "hour" ? 'selected' : ''}}>@lang('app.hour')</option>
                    <option value="minute" {{$event->remind_type == "minute" ? 'selected' : ''}}>@lang('app.minute')</option>
                </select>
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
        $("#employee_ids,#client_ids, #created_by").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $('#color-selector').colorselector();
        
        $('.edit-meeting').click(function () {
            var id = $("#id_field").val();
            var url = "{{ route('member.zoom-meeting.update', ':id') }}";
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
        $('#edit-repeat-meeting').is(':checked') ? $('#repeat-fields').show() : $('#repeat-fields').hide();
        $('#edit-send_reminder').is(':checked') ? $('#reminder-fields').show() : $('#reminder-fields').hide();

        $('#edit-repeat-meeting').change(function () {
            if($(this).is(':checked')){
                $('#edit-repeat-fields').show();
            }
            else{
                $('#edit-repeat-fields').hide();
            }
        })

        $('#edit-send_reminder').change(function () {
            if($(this).is(':checked')){
                $('#edit-reminder-fields').show();
            }
            else{
                $('#edit-reminder-fields').hide();
            }
        })
    })
</script>
