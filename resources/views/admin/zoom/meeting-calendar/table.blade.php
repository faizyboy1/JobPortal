@extends('layouts.app') @push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

<style>
    .mb-20 {
        margin-bottom: 20px
    }
    .drop-down-new li{
        padding: 5px 10px;
        font-size: 12px;
        hover: 
    }
    .drop-down-new li:hover{
        background-color: #f2f2f2;
    }
    .drop-down-new li a{
        color: black;
    }
   .repeat_type_dropdown select{
        height: 32px !important;

    }
    .table-responsive>.table-bordered {
        border: 1px solid #dee2e6 !important;
    }
</style>


@endpush 



@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row clearfix">
                    <div class="col-md-12 mb-20">
                            <a href="#" data-toggle="modal" data-target="#my-meeting" ><button class="btn btn-sm btn-primary" type="button">
                                    <i class="ti-plus"></i> @lang('modules.zoommeeting.addMeeting')
                                </button></a> 
                            <a href="{{ route('admin.zoom-meeting.index') }}"><button class="btn btn-sm btn-success" type="button">
                                    <i class="fa fa-calendar"></i>  @lang('modules.zoommeeting.calendarView')
                            </button></a> 
                    </div>
                </div>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('modules.meetings.meetingId')</th>
                                <th>@lang('modules.meetings.meetingName')</th>
                                <th>@lang('modules.meetings.startOn')</th>
                                <th>@lang('modules.meetings.endOn')</th>
                                <th>@lang('modules.meetings.status')</th>
                                <th>@lang('modules.meetings.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                <a href="javascript:;" id="addCategory" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                                 </label>
                                 <select class="select2 form-control" id="category_id" name="category_id">
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
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <label class="control-label">@lang('modules.meetings.addEmployees')
                                 </label>
                                 <select class="select2 form-control select2-multiple" multiple="multiple" id="employee_id" name="employee_id[]">
                                    @foreach($users as $emp)
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
                              <select class="select2 form-control" id="created_by" name="created_by">
                                  @foreach($users as $emp)
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
                                    <input type="checkbox" value="" name="repeat"  class="flat-red" id ="repeat-meeting"  style="position: absolute; opacity: 0;">
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
                        <div class="form-group repeat_type_dropdown">
                            <label>&nbsp;</label>
                            <select name="repeat_type" id="" class="form-control">
                                <option value="day">@lang('modules.zoommeeting.day')</option>
                                <option value="week">@lang('modules.zoommeeting.week')</option>
                                <option value="month">@lang('modules.zoommeeting.month')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-3">
                        <div class="form-group ">
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
                                    <input type="checkbox" value="" name="send_reminder"  class="flat-red" id ="send_reminder"  style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                @lang('modules.zoommeeting.reminder')
                            </label>
                            
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
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

<script>
       $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        },
        width: '100%'
    });
    
   
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
    var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: {'url' : '{!! route('admin.zoom-meeting.data') !!}',
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "filter_company": $('#filter-company').val(),
                            "filter_status": $('#filter-status').val(),
                        } );
                    }
                },
            language: languageOptions(),
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_Row_Index', name: 'DT_Row_Index' , orderable: false, searchable: false},
                { data: 'meeting_id', name: 'meeting_id' },
                { data: 'meeting_name', name: 'meeting_title' },
                { data: 'start_date_time', name: 'start_date' },
                { data: 'end_date_time', name: 'end_date' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', width: '20%' }
            ]
        });

        new $.fn.dataTable.FixedHeader( table );

        $('#filter-company, #filter-status').change(function () {
            table._fnDraw();
        })
        
    $('#repeat-meeting').on('ifChecked', function(event){
            $('#repeat-fields').show();
            });
            
            $('#repeat-meeting').on('ifUnchecked', function(event){
                $('#repeat-fields').hide();
            });

    
    $('#send_reminder').on('ifChecked', function(event){
            $('#reminder-fields').show();
            });
            
            $('#send_reminder').on('ifUnchecked', function(event){
                $('#reminder-fields').hide();
            });

    $('#repeat-meeting').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
        $('#send_reminder').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
   
    var getEventDetail = function (id) {
        var url = "{{ route('admin.zoom-meeting.show', ':id')}}";
        url = url.replace(':id', id);

        $('#modelHeading').html('Meeting');
        $.ajaxModal('#meetingDetailModal', url);
    }
   
  
    $(function() {

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('meeting-id');
            var occurrence = $(this).data('occurrence');
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
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.zoom-meeting.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
        
     
        $('body').on('click', '.end-meeting', function(){
            var id = $(this).data('meeting-id');
            console.log(id);
            var buttons = {
                cancel: "@lang('app.no')",
                confirm: {
                    text: "@lang('app.yes')",
                    value: 'confirm',
                    visible: true,
                    className: "danger",
                }
            };  
            
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.endWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.yes')",
                cancelButtonText: "@lang('app.no')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    var token = "{{ csrf_token() }}";

                    var url = "{{ route('admin.zoom-meeting.endMeeting')  }}";
                    var dataObject = {'_token': token, 'id': id};


                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: dataObject,
                        success: function (response) {
                            if (response.status == "success") {
                                loadTable();
                            }
                        }
                    });
                }
            });
        });
        
        $('body').on('click', '.cancel-meeting', function(){
            var id = $(this).data('meeting-id');
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.cancelWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.yes')",
                cancelButtonText: "@lang('app.no')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.zoom-meeting.cancelMeeting',':id') }}";
                    url = url.replace(':id', id);
                    var token = "{{ csrf_token() }}";
                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, 'id': id},
                        success: function (response) {
                            if (response.status == "success") {
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
        

        $('body').on('click', '.btnedit', function() {
            $('.modal').modal('hide');
            
            var id = $(this).data('id');
            var url = "{{ route('admin.zoom-meeting.edit', ':id')}}";
            url = url.replace(':id', id);
            $('#modelHeading').html('');
            $.ajaxModal('#meetingDetailModal', url);   
        });

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
        
    });
    $('#addCategory').click(function () {
        var url = '{{ route('admin.category.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#categoryModal', url);
    })

</script>


@endpush