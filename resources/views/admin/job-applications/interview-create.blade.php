<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">

<style>
    .online-radio-button{
        display: inline-flex;
    }
    </style>
<div class="modal-header">
<h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.interviewSchedule.interviewSchedule')</h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
</div>
<div class="modal-body">
    <form id="createSchedule" class="ajax-form" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-body">
            <div class="row">
                <div class="col-md-6  col-xs-12">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.candidate')</label>
                        <p>{{ $currentApplicant->full_name }}</p>
                        <input type="hidden" name="candidates[]" value="{{ $currentApplicant->id }}">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.employee')</label>
                        <select class="select2 m-b-10 form-control select2-multiple " multiple="multiple"
                                data-placeholder="@lang('modules.interviewSchedule.chooseEmployee')" data-placeholder="@lang('modules.interviewSchedule.employee')" name="employees[]">
                            @foreach($users as $emp)
                                <option value="{{ $emp->id }}">{{ ucwords($emp->name) }} @if($emp->id == $user->id)
                                        (@lang('app.you')) @endif</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.interviewSchedule.scheduleDate')</label>
                        <input type="text" name="scheduleDate" id="scheduleDate" placeholder="@lang('modules.interviewSchedule.scheduleDate')" value="{{$scheduleDate}}" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-md-3">
                    <div class="form-group chooseCandidate bootstrap-timepicker timepicker">
                        <label>@lang('modules.interviewSchedule.scheduleTime')</label>
                        <input type="text" name="scheduleTime" id="scheduleTime" placeholder="@lang('modules.interviewSchedule.scheduleTime')" class="form-control">
                    </div>
                </div>
                @if($zoom_setting->enable_zoom == 1)
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group" id="end_date_section" style="display: none">
                        <label>@lang('modules.interviewSchedule.endDate')</label>
                        <input type="text" name="end_date" id="end_date" data-placeholder="@lang('modules.interviewSchedule.endDate')" value="{{$scheduleDate}}" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-md-3">
                    <div class="form-group chooseCandidate bootstrap-timepicker timepicker" id="end_time_section" style="display: none">
                        <label>@lang('modules.interviewSchedule.scheduleTime')</label>
                        <input type="text" name="end_time" id="end_time" data-placeholder="@lang('modules.interviewSchedule.scheduleTime')" class="form-control">
                    </div>
                </div>
                <div class="col-xs-5 col-md-3">
                    <label>@lang('modules.interviewSchedule.interviewType')</label>
                    <div class="form-group online-radio-button">
                        <div class="">
                            <input type="radio" name="interview_type" id="interview_typeOnline" value="online">
                            <label for="interview_typeOnline" class=""> @lang('modules.meetings.online') </label>
                        </div>
                        <div class="" style ="margin-left: 21px;">
                            <input type="radio" name="interview_type" id="interview_typeOffline" value="offline" checked>
                            <label for="interview_typeOffline" class=""> @lang('modules.meetings.offline') </label>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="row" id="repeat-fields" style="display: none">
                
                <div class="col-xs-6 col-md-10">
                    <div class="form-group">
                        <label class="d-block">@lang('modules.interviewSchedule.interviewTitle')</label>
                        <input type="text" name="meeting_title" id="meeting_title" class="form-control">
                    </div>
                </div>
               
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <div class="m-b-10">
                            <label class="control-label">@lang('modules.zoommeeting.hostVideoStatus')</label>
                        </div>
                        <div class="radio radio-inline">
                            <input type="radio" name="host_video" id="host_video1" value="1">
                            <label for="host_video1" class=""> @lang('app.enable') </label>
                        </div>
                        <div class="radio radio-inline ">
                            <input type="radio" name="host_video" id="host_video2" value="0" checked>
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
                            <input type="radio" name="participant_video" id="participant_video1" value="1">
                            <label for="participant_video1" class=""> @lang('app.enable') </label>
                        </div>
                        <div class="radio radio-inline ">
                            <input type="radio" name="participant_video" id="participant_video2" value="0" checked>
                            <label for="participant_video2" class=""> @lang('app.disable') </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                          <label class="control-label">@lang('modules.interviewSchedule.host')</label>
                          <select class="select2 form-control" id="created_by" name="created_by">
                              @foreach($users as $emp)
                                  <option @if($emp->id == $user->id)
                                      selected
                                      @endif value="{{ $emp->id }}">{{ ucwords($emp->name) }}</option>
                              @endforeach
                          </select>
                    </div>
                </div>
                    <div class="col-md-12 form-group">
                            <label class="">
                                <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                    <input type="checkbox" value="1" name="send_reminder"  class="flat-red" id ="send_reminder"  style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                @lang('modules.zoommeeting.reminder')
                            </label>
                            
                    </div>
                <div class="col-md-12" id="reminder-fields" style="display: none;">
                    <div class ="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.remindBefore')</label>
                            <input type="number" min="1" value="1" name="remind_time" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="form-group repeat_type_dropdown">
                            <label>&nbsp;</label>
                            <select name="remind_type" id="" class="form-control">
                                <option value="day">@lang('modules.zoommeeting.day')</option>
                                <option value="hour">@lang('modules.zoommeeting.hour')</option>
                                <option value="minute">@lang('modules.zoommeeting.minute')</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" class="btn btn-success save-schedule">@lang('app.submit')</button>
</div>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>

<script>
    // Select 2 init.
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    // Datepicker set
    $('#scheduleDate').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
    });
    $('#end_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
        minDate : new Date()
    });
    // $('#colorselector').colorselector();

    // Timepicker Set
    $('#scheduleTime').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: true,   // look it
        format: 'HH:mm',
        switchOnClick: true
    });
    $('#end_time').bootstrapMaterialDatePicker
        ({
            date: false,
            shortTime: true,   // look it
            format: 'HH:mm',
            switchOnClick: true
        });
    // Save Interview Schedule
    $('.save-schedule').click(function () {
        $.easyAjax({
            url: '{{route('admin.job-applications.store-schedule')}}',
            container: '#createSchedule',
            type: "POST",
            data: $('#createSchedule').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })
    $('#send_reminder').on('ifChecked', function(event){
            $('#reminder-fields').show();
            });
            
            $('#send_reminder').on('ifUnchecked', function(event){
                $('#reminder-fields').hide();
            });
            $('#send_reminder').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
        $('input[type=radio][name=interview_type]').change(function () {
            if(this.value == 'online'){
            $('#repeat-fields').show();
            $('#end_time_section').show();
            $('#end_date_section').show();
        }
        else{
            $('#repeat-fields').hide();
            $('#end_time_section').hide();
            $('#end_date_section').hide();
        }
    })
</script>
