@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> @lang($pageTitle)</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('assets/plugins/calendar/dist/fullcalendar.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
<style>
    /* #category_id{
        width: 100% !important;
    } */

    .table-responsive>.table-bordered {
        border: 1px solid #dee2e6 !important;
    }
    </style>
@endpush

@section('content')
<div class=" text-right">
    <a href="#" data-toggle="modal" data-target="#my-meeting" class="btn btn-sm btn-primary">
        <i class="ti-plus"></i> @lang('modules.zoommeeting.addMeeting')
    </a>
    <a href="{{ route('admin.zoom-meeting.table-view') }}" class="btn btn-sm btn-success">
        <i class="ti-list"></i> @lang('modules.zoommeeting.tableView')
    </a>
    
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <!-- BEGIN MODAL -->
    <div class="modal fade bs-modal-md in" id="my-meeting" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
       <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.zoommeeting.addMeeting')</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            </div>
           <div class="modal-body">
            {!! Form::open(['id'=>'createMeeting','class'=>'ajax-form','method'=>'POST']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">@lang('modules.zoommeeting.meetingName')</label>
                                <input type="text" name="meeting_title" id="meeting_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style ="margin: -5px;">
                                <label class="control-label">@lang('app.category')
                                    <a href="javascript:;" id="addCategory" class="btn btn-xs btn-success btn-outline fs-12"><i class="fa fa-plus"></i></a>
                                     </label>
                                     <select class="select2 form-control" id="category_id" name="category_id" style="width: 100%;!important">
                                        <option value="">@lang('modules.message.pleaseSelectCategory')</option>
                                         @foreach($categories as $category)
                                             <option value="{{ $category->id }}">{{ ucwords($category->category_name) }}</option>
                                         @endforeach
                                        </select>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-xs-12 col-md-12 ">
                            <div class="form-group">
                                <label>@lang('modules.zoommeeting.description')</label>
                                <textarea type="text" name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group chooseCandidate ">
                                <label class="required">@lang('modules.zoommeeting.startOn')</label>
                                <input type="text" name="start_date" id="start_date" class="form-control new_date" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group  bootstrap-timepicker timepicker">
                                <label>&nbsp;</label>
                                <input type="text" name="start_time" id="start_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group chooseCandidate bootstrap-timepicker timepicker">
                                <label class="required">@lang('modules.zoommeeting.endOn')</label>
                                <input type="text" name="end_date" id="end_date" class="form-control" autocomplete="none">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group  bootstrap-timepicker timepicker">
                                <label>&nbsp;</label>
                                <input type="text" name="end_time" id="end_time" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12 col-md-12" id="member-attendees">
                            <label class="col-xs-3 m-t-10">@lang('modules.meetings.addEmployees')</label>
                            <div class="form-group col-xs-12 col-md-12 p-0">
                                <select class="select2 m-b-10 select2-multiple " style="width:100%" multiple="multiple"
                                        data-placeholder="@lang('modules.message.chooseMember')" name="employee_id[]">
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ ucwords($emp->name) }} @if($emp->id == $user->id)
                                                (YOU) @endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                                  <label class="control-label">@lang('modules.zoommeeting.meetingHost')</label>
                                  <select class="select2 form-control created_by" style="width:100%"id="created_by" name="created_by">
                                      @foreach($employees as $emp)
                                          <option @if($emp->id == $user->id)
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
                                <label class="">
                                    <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="checkbox" value="" name="repeat"  class="flat-red" id ="repeat-meeting-new"  style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div>
                                    @lang('modules.zoommeeting.repeat')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="repeat-fields" style="display: none">
                        <div class="col-xs-6 col-md-3 ">
                            <div class="form-group">
                                <label>@lang('modules.zoommeeting.repeatEvery')</label>
                                <input type="number" min="1" value="1" name="repeat_every" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <select name="repeat_type" id="" style=" height: 32px !important;"class="form-control ">
                                    <option value="day">@lang('modules.zoommeeting.day')</option>
                                    <option value="week">@lang('modules.zoommeeting.week')</option>
                                    <option value="month">@lang('modules.zoommeeting.month')</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>@lang('modules.zoommeeting.cycles') <a class="mytooltip" href="javascript:void(0)"> </a></label>
                                <input type="text" name="repeat_cycles" id="repeat_cycles" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="">
                                    <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="checkbox" value="" name="send_reminder"  class="flat-red" id ="send_reminder_new"  style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div>
                                    @lang('modules.zoommeeting.reminder')
                                </label>
                                {{-- <div class="checkbox checkbox-info">
                                    <input id="send_reminder" name="send_reminder" value="1"
                                            type="checkbox">
                                    <label for="send_reminder">@lang('modules.zoommeeting.reminder')</label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row" id="reminder-fields" style="display: none;">
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>@lang('modules.zoommeeting.remindBefore')</label>
                                <input type="number" min="1" value="1" name="remind_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <select name="remind_type" id="" style=" height: 32px !important;" class="form-control">
                                    <option value="day">@lang('modules.zoommeeting.day')</option>
                                    <option value="hour">@lang('modules.zoommeeting.hour')</option>
                                    <option value="minute">@lang('modules.zoommeeting.minute')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                {!! Form::close() !!}
        
        </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">@lang('app.close')</button>
               <button type="button" class="btn btn-success save-meeting waves-effect waves-light">@lang('app.submit')</button>
           </div>
       </div>
    </div>
    </div>
    {{-- End  --}}

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="meetingDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
    {{--Category Modal--}}
    <div class="modal fade bs-modal-md in" id="categoryModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Category Ajax Modal Ends--}}

@endsection

@push('footer-script')
<script>
    var taskEvents = [
        @foreach($events as $event)
        {
            id: '{{ ucfirst($event->id) }}',
            title: '{{ ucfirst($event->meeting_name) }}',
            start: '{{ $event->start_date_time }}',
            end:  '{{ $event->end_date_time }}',
            className: '{{ $event->label_color }}'
        },
        @endforeach
    ];

    var getEventDetail = function (id) {
        var url = "{{ route('admin.zoom-meeting.show', ':id')}}";
        url = url.replace(':id', id);

        $('#modelHeading').html('Meeting');
        $.ajaxModal('#meetingDetailModal', url);
    }

    var calendarLocale = '{{ $global->locale }}';
</script>
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"
type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}"
type="text/javascript"></script>
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('assets/plugins/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/meeting-calendar.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>


<script>
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    $('#colorselector').colorselector();
    // Datepicker set
    $('#start_date, #end_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
        minDate : new Date()
    });

    // Timepicker Set
    $('#start_time, #end_time').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: true,   // look it
        format: 'HH:mm',
        switchOnClick: true
    });

    function addEventModal(start, end, allDay){
        $('.modal').modal('hide');
        if(start){
            var sd = new Date(start);
                var curr_date = sd.getDate();
                if (curr_date < 10) {
                    curr_date = '0' + curr_date;
                }
                var curr_month = sd.getMonth();
                curr_month = curr_month + 1;
                if (curr_month < 10) {
                    curr_month = '0' + curr_month;
                }
                var curr_year = sd.getFullYear();
                scheduleDate = curr_year + '-' + curr_month + '-' + curr_date;
                $('#start_date').val(scheduleDate);
                $('#end_date').val(scheduleDate);
        }
        $('#my-meeting').modal('show');
    }

    $('.save-meeting').click(function () {
        $.easyAjax({
            url: "{{ route('admin.zoom-meeting.store') }}",
            container: '#modal-data-application',
            type: "POST",
            data: $('#createMeeting').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })
    $('#repeat-meeting-new').on('ifChecked', function(event){
            $('#repeat-fields').show();
            });
            
            $('#repeat-meeting-new').on('ifUnchecked', function(event){
                $('#repeat-fields').hide();
            });
          
            $('#send_reminder_new').on('ifChecked', function(event){
            $('#reminder-fields').show();
            });
            
            $('#send_reminder_new').on('ifUnchecked', function(event){
                $('#reminder-fields').hide();
            });
            $('#repeat-meeting-new').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
        $('#send_reminder_new').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
   
    $('#addCategory').click(function () {
        var url = '{{ route('admin.category.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#categoryModal', url);
    })

</script>

@endpush
