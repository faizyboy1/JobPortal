<div id="event-detail">

    <div class="modal-header">
        <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.zoommeeting.meetingDetails')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </div>
    <div class="modal-body">
        {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'GET']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label> @lang('modules.zoommeeting.meetingName')</label>
                        <p>
                            
                            {{ ucfirst($event->meeting_name) }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="font-12" for="">@lang('modules.zoommeeting.viewAttendees')</label><br>
                    @foreach ($event->attendees as $item)
                    @if(is_null($item->image))
                    <img src="{{ asset('avatar.png') }}" data-toggle="tooltip" data-original-title="{{ ucwords($item->name) }}" width="25" height="25" class="img-circle img-fluid">
                    @else

                        <img src="{{ $item->image_url }}" data-toggle="tooltip"
                             data-original-title="{{ ucwords($item->name) }}" data-placement="right"
                             class="img-circle" width="25" height="25" alt="">
                             @endif
                    @endforeach
                </div>

                <div class="col-md-4">
                    <label class="font-12" for="">@lang('modules.zoommeeting.meetingHost')</label><br>
                    @if(is_null($event->host->image))
                    <img src="{{ asset('avatar.png') }}" data-toggle="tooltip" data-original-title="{{ ucwords($event->host->name) }}" width="25" height="25" class="img-circle img-fluid">
                    @else
                    <img src="{{ $event->host->image_url }}" class="img-circle" width="25" height="25" alt=""> {{ ucwords($event->host->name) }}
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label>@lang('app.description')</label>
                        <p>{{ $event->description ?? "--" }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.zoommeeting.hostVideoStatus')</label>
                        <p>{{ $event->host_video ? __('modules.meetings.enabled') : __('modules.meetings.disabled') }}</p>
                    </div>
                </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.participantVideoStatus')</label>
                            <p>{{ $event->participant_video ? __('modules.meetings.enabled') : __('modules.meetings.disabled') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('modules.zoommeeting.categoryName')</label>
                            <p>{{ $event->category == null ? "--" : $event->category->category_name }}</p>
                        </div>
                    </div>
                   
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.zoommeeting.startOn')</label>
                        <p>{{ $event->start_date_time}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.zoommeeting.endOn')</label>
                        <p>{{ $event->end_date_time }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('app.password')</label>
                        <p>{{ $event->password ?? "--" }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('app.status')</label>
                        <p>
                            @if ($event->status == 'waiting')
                                <label class="label label-warning badge">{{ __('modules.zoommeeting.waiting') }}</label>
                            @elseif ($event->status == 'live')
                                <i class="fa fa-circle Blink" style="color: red"></i> <span class="font-semi-bold">{{ __('modules.zoommeeting.live') }}</span>
                            @elseif ($event->status == 'canceled')
                                <label class="label label-danger badge">{{ __('app.canceled') }}</label>
                            @elseif ($event->status == 'finished')
                                <label class="label label-success badge">{{ __('app.finished') }}</label>
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="modal-footer">
        @php
            if ($zoomSetting->meeting_app == 'in_app') {
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
                    <a href="{{ $url }}" target="_blank" class="btn btn-success waves-effect"><i class="fa fa-play"></i> @lang('modules.zoommeeting.startMeeting')</a>
                @endif

            @endif

     
        @else
            @if ($event->status == 'waiting' || $event->status == 'live')
                @php
                    $meetingDate = $event->start_date_time->toDateString();                    
                @endphp

                @if (is_null($event->occurrence_id) || $nowDate == $meetingDate)
                    <a href="{{ $url }}" target="_blank" class="btn btn-info waves-effect" ><i class="fa fa-play"></i> @lang('modules.zoommeeting.joinUrl')</a>
                @endif

            @endif
        @endif
        <a href="javascript:;" data-dismiss="modal" class="btn btn-default waves-effect" >@lang('app.close')</a>
    </div>

</div>

<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
     $('body').on('click', '.delete-event', function () {
        var occurrence = "{{ $event->occurrence_order }}"

        var buttons = {
            cancel: "@lang('app.no')",
            confirm: {
                text: "@lang('app.yes')",
                value: 'confirm',
                visible: true,
                className: "danger",
            }
        };

        if(occurrence == '1')
        {
            buttons.recurring = {
                text: "{{ trans('modules.zoommeeting.deleteAllOccurrences') }}",
                value: 'recurring'
            }
        }

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted meeting!",
            dangerMode: true,
            icon: 'warning',
            buttons: buttons,
        }).then(function (isConfirm) {
            if (isConfirm == 'confirm' || isConfirm == 'recurring') {

                var url = "{{ route('admin.zoom-meeting.destroy', $event->id) }}";

                var token = "{{ csrf_token() }}";
                var dataObject = {'_token': token, '_method': 'DELETE'};

                if(isConfirm == 'recurring')
                {
                    dataObject.recurring = 'yes';
                }

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: dataObject,
                    success: function (response) {
                        if (response.status == "success") {
                            window.location.reload();
                        }
                    }
                });
            }


        });
    });

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    })

    $('body').on('click', '.save-event', function () {
        // $('.modal').modal('hide');
        $('#meetingDetailModal .modal-content').html('');

        var url = "{{ route('admin.zoom-meeting.edit', $event->id) }}";
        $.ajaxModal('#meetingDetailModal', url);   
    })

</script>