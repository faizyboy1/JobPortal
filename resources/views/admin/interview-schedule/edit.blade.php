<link rel="stylesheet"
    href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}"> --}}

<style>
    .online-radio-button {
        display: inline-flex;
    }

</style>
<div class="modal-header">
    <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.interviewSchedule.interviewSchedule')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
</div>
<div class="modal-body">
    <form id="updateSchedule" class="ajax-form" method="put">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-body">
            <div class="row">
                <div class="col-md-6  col-xs-12">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.candidate')</label>
                        <select disabled class="select2 m-b-10 form-control"
                            data-placeholder="@lang('modules.interviewSchedule.chooseCandidate')">
                            @foreach ($candidates as $candidate)
                                <option @if ($schedule->job_application_id == $candidate->id) selected @endif value="{{ $candidate->id }}">
                                    {{ ucwords($candidate->full_name) }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="candidate_id" value="{{ $schedule->job_application_id }}">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.employee')</label>
                        <select class="select2 m-b-10 form-control select2-multiple " multiple="multiple"
                            data-placeholder="@lang('modules.interviewSchedule.chooseEmployee')" name="employee[]"
                            id="employee">
                            @foreach ($users as $emp)
                                <option value="{{ $emp->id }}">{{ ucwords($emp->name) }} @if ($emp->id == $user->id)
                                        (@lang('app.you')) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.interviewSchedule.scheduleDate')</label>
                        <input type="text" name="scheduleDate" id="scheduleDate"
                            value="{{ $schedule->schedule_date->format('Y-m-d') }}" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-md-3">
                    <div class="form-group chooseCandidate bootstrap-timepicker timepicker">
                        <label>@lang('modules.interviewSchedule.scheduleTime')</label>
                        <input type="text" name="scheduleTime" id="scheduleTime"
                            value="{{ $schedule->schedule_date->format('H:i') }}" class="form-control">
                    </div>
                </div>
                @if($zoom_setting->enable_zoom == 1)
               
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group"  id="end_date_section">
                        <label>@lang('modules.interviewSchedule.endDate')</label>
                        <input type="text" name="end_date" id="end_date" value="{{ ($schedule->meeting != null) ?$schedule->meeting->end_date_time->format('Y-m-d') : '' }}" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-md-3">
                    <div class="form-group chooseCandidate bootstrap-timepicker timepicker" id="end_time_section" >
                        <label>@lang('modules.interviewSchedule.scheduleTime')</label>
                        <input type="text" name="end_time" id="end_time" value="{{  ($schedule->meeting != null)?$schedule->meeting->end_date_time->format('H:i') : ''}}" class="form-control">
                    </div>
                </div>
                
                <div class="col-xs-5 col-md-3">
                    <label>@lang('modules.interviewSchedule.interviewType')</label>
                    <div class="form-group online-radio-button">
                        <div class="">
                            <input type="radio" name="interview_type" id="interview_type" value="online" {{ ($schedule->interview_type == 'online')? "checked" : "" }} >
                            <label for="online" class=""> @lang('modules.meetings.online') </label>
                        </div>
                        <div class="" style="margin-left: 21px;">
                            <input type="radio" name="interview_type" id="interview_type" value="offline" {{($schedule->interview_type == 'offline' || $schedule->interview_type == null)? "checked" : "" }}>
                            <label for="offline" class=""> @lang('modules.meetings.offline') </label>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @if($zoom_setting->enable_zoom == 1)
            <div class="row" id="meeting-fields" style="display: none">

                <div class="col-xs-6 col-md-10">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.interviewTitle')</label>
                        <input type="text" name="meeting_title" id="meeting_title" @if($schedule->meeting) value="{{$schedule->meeting->meeting_name ?? ''}}" @endif class="form-control">
                    </div>
                </div>
               
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <div class="m-b-10">
                            <label class="control-label">@lang('modules.zoommeeting.hostVideoStatus')</label>
                        </div>
                        <div class="radio radio-inline">
                            <input type="radio" name="host_video" id="host_video1" value="1" @if($schedule->meeting) {{ $schedule->meeting->host_video ? "checked" : "" }} @endif>
                            <label for="host_video1" class=""> @lang('app.enable') </label>
                        </div>
                        <div class="radio radio-inline ">
                            <input type="radio" name="host_video" id="host_video2" value="0" @if($schedule->meeting) {{ !$schedule->meeting->host_video ? "checked" : "" }} @else checked @endif>
                            <label for="host_video2" class=""> @lang('app.disable') </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="m-b-10">
                            <label class="control-label">@lang('modules.zoommeeting.participantVideoStatus')</label>
                        </div>
                        <div class="radio radio-inline">
                            <input type="radio" name="participant_video" id="participant_video1" value="1" @if($schedule->meeting) {{ $schedule->meeting->participant_video ? "checked" : "" }} @endif>
                            <label for="participant_video1" class=""> @lang('app.enable') </label>
                        </div>
                        <div class="radio radio-inline ">
                            <input type="radio" name="participant_video" id="participant_video2" value="0" @if($schedule->meeting) {{ !$schedule->meeting->participant_video ? "checked" : "" }} @else checked @endif>
                            <label for="participant_video2" class=""> @lang('app.disable') </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">@lang('modules.interviewSchedule.host')</label>
                        <select class="select2 form-control" id="created_by" name="created_by">
                            @foreach ($users as $emp)
                                <option @if ($emp->id == $user->id) selected @endif value="{{ $emp->id }}">{{ ucwords($emp->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="">
                        <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false"
                            style="position: relative;">
                            <input type="checkbox" value="1" name="send_reminder" @if($schedule->meeting) {{ ($schedule->meeting->send_reminder)? "checked" : "" }} @endif  class="flat-red" id="send_reminder"
                                style="position: absolute; opacity: 0;">
                            <ins class="iCheck-helper"
                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        @lang('modules.zoommeeting.reminder')
                    </label>

                </div>
                <div class="col-md-12" id="reminder-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('modules.zoommeeting.remindBefore')</label>
                                <input type="number" min="1" @if($schedule->meeting) value= "{{$schedule->meeting->remind_time}}" @endif value="1" name="remind_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group repeat_type_dropdown">
                                <label>&nbsp;</label>
                                <select name="remind_type" id="" class="form-control">
                                    <option value="day" @if($schedule->meeting) {{$schedule->meeting->remind_type == "day" ? 'selected' : ''}} @endif>@lang('modules.zoommeeting.day')</option>
                                    <option value="hour" @if($schedule->meeting) {{$schedule->meeting->remind_type == "day" ? 'selected' : ''}} @endif>@lang('modules.zoommeeting.hour')</option>
                                    <option value="minute" @if($schedule->meeting) {{$schedule->meeting->remind_type == "day" ? 'selected' : ''}} @endif>@lang('modules.zoommeeting.minute')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12 ">
                    <div class="form-group">
                        <label>@lang('modules.interviewSchedule.comment')</label>
                        <textarea type="text" name="comment" id="comment"
                            class="form-control">{{ $comment->comment ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" class="btn btn-success update-schedule">@lang('app.update')</button>
</div>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
<script
src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"
type="text/javascript"></script>
{{-- <script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script> --}}


<script>
    
    // Select 2 Init
    $(".select2").select2({
        formatNoMatches: function() {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('#employee').val({{ $employeeList }}).change();

    // Datepicker Set
    $('#scheduleDate').bootstrapMaterialDatePicker({
        time: false,
        clearButton: true,
    });
    $('#end_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
        minDate : new Date()
    });
    $('#end_time').bootstrapMaterialDatePicker
        ({
            date: false,
            shortTime: true,   // look it
            format: 'HH:mm',
            switchOnClick: true
        });
    // $('#colorselector').colorselector();
    $('#send_reminder').is(':checked') ? $('#reminder-fields').show() : $('#reminder-fields').hide();
    // $('#interview_type').is(':checked') ? $('#meeting-fields').show() : $('#meeting-fields').hide();

    // Timepicker Set
    $('#scheduleTime').bootstrapMaterialDatePicker({
        date: false,
        shortTime: true, // look it
        format: 'HH:mm',
        switchOnClick: true
    });

    // Update Schedule
    $('.update-schedule').click(function() {
        $.easyAjax({
            url: '{{ route('admin.interview-schedule.update', $schedule->id) }}',
            container: '#updateSchedule',
            type: "PUT",
            data: $('#updateSchedule').serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        })
    })
    @if($schedule->interview_type == 'online')
    $('#end_time_section').show();
    $('#end_date_section').show();
    @else
    $('#end_date_section').hide();
    $('#end_time_section').hide();
    @endif
    $('#send_reminder').on('ifChecked', function(event){
            $('#reminder-fields').show();
            });
            
            $('#send_reminder').on('ifUnchecked', function(event){
                $('#reminder-fields').hide();
            });
            $('#send_reminder').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
    var value = $('input[name="interview_type"]:checked').val();
        if(value == 'offline' || value == null){
            $('#meeting-fields').hide();
            $('#end_date_section').hide();
            $('#end_time_section').hide();
            
        }else{
            $('#meeting-fields').show();
            $('#end_date_section').show();
            $('#end_time_section').show();
            
        }

    $('input[type=radio][name=interview_type]').change(function () {
            if(this.value == 'online'){
            $('#meeting-fields').show();
            $('#end_date_section').show();
            $('#end_time_section').show();
        }
        else{
            $('#meeting-fields').hide();
            $('#end_date_section').hide();
            $('#end_time_section').hide();
        }
    })
</script>
