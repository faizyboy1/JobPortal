<style>
    .notify-button-show{
        /*width: 9em;*/
        height: 1.5em;
        font-size: 0.730rem !important;
        line-height: 0.5 !important;
    }
    .radio-position {
        position: absolute; opacity: 0;
    }
    .radio-icheck-position{
        position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;
    }

</style>
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

<div class="modal-header">
    <h4 class="modal-title">@lang('modules.interviewSchedule.interviewSchedule')
        @if($schedule->interview_type == 'offline')
            <label class="badge badge-info">@lang('app.offline')</label>
        @else
            <label class="badge badge-info">@lang('app.online')</label>
        @endif
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row font-12">
            <div class="col-md-12">
                <h4>@lang('modules.interviewSchedule.candidateDetail')</h4>
            </div>

            <div class="col-sm-12 col-md-4">
                <strong>@lang('app.name')</strong><br>
                <p class="text-muted">{{ ucwords($schedule->jobApplication->full_name) }}</p>
            </div>

            <div class="col-sm-12 col-md-4">
                <strong>@lang('app.email')</strong><br>
                <p class="text-muted">{{ $schedule->jobApplication->email }}</p>
            </div>

            <div class="col-sm-12 col-md-4">
                <strong>@lang('app.phone')</strong><br>
                <p class="text-muted">{{ $schedule->jobApplication->phone }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <h4>@lang('modules.interviewSchedule.scheduleEditDetail')</h4>
            </div>
            <div class="col-md-5">
                @if ($currentDateTimestamp <= $schedule->schedule_date->timestamp && $user->cans('edit_schedule'))
                    <button onclick="editSchedule()" class="btn btn-sm btn-info notify-button-show" title="Edit"> <i
                            class="fa fa-pencil"></i> @lang('app.edit')</button>
                @endif
            </div>
        </div>

        <div class="col-sm-12">
            <strong>@lang('modules.interviewSchedule.job')</strong><br>
            <p class="text-muted">
                {{ ucwords($schedule->jobApplication->job->title) . ' (' . ucwords($schedule->jobApplication->job->location->location) . ')' }}
            </p>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <strong>@lang('modules.interviewSchedule.assignedEmployee')</strong><br>
            </div>
            <div class="col-sm-6">
                <strong>@lang('modules.interviewSchedule.employeeResponse')</strong><br>
            </div>

            @forelse($schedule->employee as $key => $emp )
                <div class="col-sm-6">
                    <p class="text-muted">{{ ucwords($emp->user->name) }}</p>
                </div>

                <div class="col-sm-6">
                    @if ($emp->user_accept_status == 'accept')
                        <label class="badge badge-success">{{ ucwords($emp->user_accept_status) }}</label>
                    @elseif($emp->user_accept_status == 'refuse')
                        <label class="badge badge-danger">{{ ucwords($emp->user_accept_status) }}</label>
                    @else
                        <label class="badge badge-warning">{{ ucwords($emp->user_accept_status) }}</label>
                    @endif
                </div>
            @empty
                <div class="col-sm-12 text-center text-muted">
                    <strong>@lang('modules.interviewSchedule.noEmployeeAssigned')</strong><br>
                </div>
            @endforelse
            @if ($zoom_setting->enable_zoom == 1)
                @if ($schedule->interview_type == 'online')
                    <div class="col-sm-6">
                        <strong>@lang('modules.zoommeeting.meetingName')</strong><br>
                        <p class="text-muted">{{ ucwords($schedule->meeting->meeting_name) }}</p>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.meetingStatus')</label>
                            <p>
                                @if ($schedule->meeting->status == 'waiting')
                                    <label
                                        class="label label-warning badge">{{ __('modules.zoommeeting.waiting') }}</label>
                                @elseif ($schedule->meeting->status == 'live')
                                    <i class="fa fa-circle Blink" style="color: red"></i> <span
                                        class="font-semi-bold">{{ __('modules.zoommeeting.live') }}</span>
                                @elseif ($schedule->meeting->status == 'canceled')
                                    <label class="label label-danger badge">{{ __('app.canceled') }}</label>
                                @elseif ($schedule->meeting->status == 'finished')
                                    <label class="label label-success badge">{{ __('app.finished') }}</label>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.startOn')</label>
                            <p>{{ $schedule->meeting->start_date_time }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.endOn')</label>
                            <p>{{ $schedule->meeting->end_date_time }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label>@lang('app.zoomMeeting') @lang('app.password')</label>
                            <p>{{ $schedule->meeting->password ?? '--' }}</p>
                        </div>
                    </div>

                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.hostVideoStatus')</label>
                            <p>{{ $schedule->meeting->host_video ? __('modules.meetings.enabled') : __('modules.meetings.disabled') }}
                            </p>
                        </div>
                    </div>

                @endif
            @endif
        </div>

        <div class="row">

            <div class="col-sm-6">
                <strong>@lang('modules.interviewSchedule.interviewType')</strong><br>
                <p class="text-muted">@if($schedule->interview_type == 'online') @lang('app.online') @else  @lang('app.offline') @endif</p>
            </div>


            @if ($schedule->interview_type == 'online' && $schedule->meeting->status != 'meeting' && $schedule->meeting->status != 'canceled')
                <div class="col-sm-6">
                    <p class="text-muted">
                        @if ($schedule->jobApplication->resume_url)
                            <a target="_blank" href="{{ $schedule->jobApplication->resume_url }}"
                                class="btn btn-sm btn-primary">@lang('app.view')
                                @lang('modules.jobApplication.resume')</a>
                        @endif
                        @if($zoom_setting->status == 'active')
                            @php
                                $event = $schedule->meeting;
                                if ($zoom_setting->meeting_app == 'in_app') {
                                    $url = route('admin.zoom-meeting.startMeeting', $event->id);
                                } else {
                                    $url = user()->id == $event->created_by ? $event->start_link : $event->end_link;
                                }
                            @endphp
                            @if (user()->id == $event->created_by)
                                @if ($event->status == 'waiting')
                                    @php
                                        $meetingDate = $event->start_date_time->toDateString();
                                    @endphp
                                    @if (is_null($event->occurrence_id) || $nowDate == $meetingDate)
                                        <a href="{{ $url }}" target="_blank"
                                            class="btn btn-success btn-sm waves-effect"><i class="fa fa-play"></i>
                                            @lang('modules.zoommeeting.startMeeting')</a>
                                    @endif
                                @endif
                            @else
                                @if ($event->status == 'waiting' || $event->status == 'live')
                                @php
                                    $meetingDate = $event->start_date_time->toDateString();
                                @endphp
                                @if (is_null($event->occurrence_id) || $nowDate == $meetingDate)
                                    <a href="{{ $url }}" target="_blank"
                                        class="btn btn-info btn-sm waves-effect"><i class="fa fa-play"></i>
                                        @lang('modules.zoommeeting.joinUrl')</a>
                                @endif
                            @endif
                        @endif
                        @endif

                    </p>
                </div>
            @endif
        </div>

        @if ($schedule->jobApplication->schedule->comments == 'interview' && count($application->schedule->comments) > 0)
            <hr>

            <h5>@lang('modules.interviewSchedule.comments')</h5>
            @forelse($schedule->jobApplication->schedule->comments as $key => $comment )
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted">{{ $comment->user->name }}</p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <p class="text-muted">{{ $comment->comment }}</p>
                </div>
            @empty
            @endforelse

        @endif

        <div class="row">
            <div class="col-sm-12">
                <label>@lang('app.status')</label>

                <div class="form-group">
                    <label for="rejected">
                        <div class="iradio_minimal-blue" aria-checked="" aria-disabled="false"
                            style="position: relative;font-size: .7rem">
                            <input id="rejected" type="radio" @if ($schedule->status == 'rejected') checked @endif
                                name="r1" class="minimal" style="position: absolute; opacity: 0;"><ins
                                class="iCheck-helper"
                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        @lang('app.rejected')
                    </label>
                    <label for="hired">
                        <div class="iradio_minimal-blue" aria-checked="" aria-disabled="false"
                            style="position: relative;margin-left: 10px;font-size: .7rem">
                            <input id="hired" type="radio" @if ($schedule->status == 'hired') checked @endif name="r1" class="minimal"
                                style="position: absolute; opacity: 0;"><ins class="iCheck-helper"
                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0; "></ins>
                        </div>
                        @lang('app.hired')
                    </label>
                    <label for="pending">
                        <div class="iradio_minimal-blue" aria-checked="" aria-disabled="false"
                            style="position: relative;margin-left: 10px;font-size: .7rem">
                            <input id="pending" type="radio" @if ($schedule->status == 'pending') checked @endif name="r1" class="minimal"
                                style="position: absolute; opacity: 0;"><ins class="iCheck-helper"
                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        @lang('app.pending')
                    </label>
                    <label for="canceled">
                        <div class="iradio_minimal-blue" aria-checked="" aria-disabled="false"
                            style="position: relative;margin-left: 10px;font-size: .7rem">
                            <input id="canceled" type="radio" @if ($schedule->status == 'canceled') checked @endif
                                name="r1" class="minimal" style="position: absolute; opacity: 0;"><ins
                                class="iCheck-helper"
                                style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0; "></ins>
                        </div>
                        @lang('app.canceled')
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">@lang('app.close')</button>
</div>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
    })

    $('input[type="radio"].minimal').on('ifChecked', function(e) {
        statusChange($(this).prop('id'));
    })

    // Employee Response on schedule
    function statusChange(status) {
        var msg;

        swal({
            title: "@lang('errors.askForCandidateEmail')",
            text: msg,
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#0c19dd",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.no')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                statusChangeConfirm(status , 'yes')
            }
            else{
                statusChangeConfirm(status , 'no')
            }

        });
    }

    // change Schedule schedule
    function statusChangeConfirm(status, mailToCandidate) {
        var token = "{{ csrf_token() }}";
        var id = "{{$schedule->id}}";
        $.easyAjax({
            url: '{{route('admin.interview-schedule.change-status')}}',
            container: '.modal-body',
            type: "POST",
            data: {'_token': token,'status': status,'id': id,'mailToCandidate': mailToCandidate},
            success: function (response) {
                @if($tableData)
                    table._fnDraw();
                @else
                    reloadSchedule();
                @endif
                $('#scheduleDetailModal').modal('hide');
            }
        })
    }
    function editSchedule() {
        var url = "{{ route('admin.interview-schedule.edit', $schedule->id) }}";
        $('#modelHeading').html('Schedule');
        $('#scheduleEditModal').modal('hide');
        $.ajaxModal('#scheduleEditModal', url);
    }

</script>

