<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
<style>
     .repeat_type_dropdown select{
        height: 32px !important;

    }
    </style>
<div class="modal-header">
    <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.zoommeeting.editMeeting')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'editMeeting','class'=>'ajax-form','method'=>'POST']) !!}
                @method('PUT')
    <input type="hidden" name ="id_field" id ="id_field"  value="{{$event->id}}" >
    <div class="row">
        <div class="col-md-6 ">
            <div class="form-group">
                <label class="required">@lang('modules.zoommeeting.meetingName')</label>
                <input type="text" name="meeting_title" id="meeting_title" value="{{$event->meeting_name}}" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" style ="margin: -3px;">
                    <label class="control-label">@lang('app.category')
                        <a href="javascript:;" id="add_category" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                    </label>
                        <select class="select2 form-control" id="category_id_edit" name="category_id">
                        <option value="">@lang('modules.message.pleaseSelectCategory')</option>
                            @foreach($categories as $category)
                                <option @if($category->id == $event->category_id)
                                    selected
                                    @endif value="{{ $category->id }}">{{ ucwords($category->category_name) }}</option>
                            @endforeach
                        </select>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-xs-12  col-md-12">
           
            <div class="form-group">
                <label>@lang('modules.zoommeeting.description')</label>
                <textarea name="description"  id="description" class="form-control">{{ ucfirst($event->description) }}</textarea>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-md-3 ">
            <div class="form-group">
                <label class="required">@lang('modules.zoommeeting.startOn')</label>
                <input type="text" name="start_date" id="start_date" value="{{ $event->start_date_time->format('Y-m-d') }}" class="form-control" autocomplete="none">
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="form-group bootstrap-timepicker timepicker">
                <label>&nbsp;</label>
                <input type="text" name="start_time"  value="{{ $event->start_date_time->format('H:i') }}"  id="start_time" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <label class="required">@lang('modules.zoommeeting.endOn')</label>
                <input type="text" name="end_date" id="end_date" value="{{ $event->end_date_time->format('Y-m-d')  }}" class="form-control" autocomplete="none">
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="form-group bootstrap-timepicker timepicker">
                <label>&nbsp;</label>
                <input type="text" name="end_time" id="end_time" value="{{ $event->end_date_time->format('H:i')  }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="control-label">@lang('modules.meetings.addEmployees')
                     </label>
                     <select class="select2 form-control select2-multiple" id="employee_id" name="employee_id[]">
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{in_array($emp->id, $event->attendees->pluck('id')->toArray())  ? 'selected' : ''}}>{{ ucwords($emp->name) }}
                        </option>
                    @endforeach
                        </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <div class="m-b-10">
                    <label class="control-label">@lang('modules.zoommeeting.hostVideoStatus')</label>
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
                    <label class="control-label">@lang('modules.zoommeeting.participantVideoStatus')</label>
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
                  <label class="control-label">@lang('modules.zoommeeting.meetingHost')</label>
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
        <div class="col-md-4">
            <div class="form-group form-group form-group-inline">
                <label class="">
                    <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                        <input type="checkbox" value="" name="send_reminder" {{ ($event->send_reminder)? "checked" : "" }} class="flat-red" id ="edit-send_reminder"  style="position: absolute; opacity: 0;">
                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                    </div>
                    @lang('modules.zoommeeting.reminder')
                </label>
                
               
            </div>
        </div>
        
    </div>

    <div class="row" id="edit-reminder-fields" style="display: none;">
        <div class="col-xs-6 col-md-3">
            <div class="form-group">
                <label>@lang('modules.zoommeeting.remindBefore')</label>
                <input type="number" min="1" value="{{$event->remind_time}}" name="remind_time" id="remind_time" class="form-control">
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group repeat_type_dropdown">
                <label>&nbsp;</label>
                
                <select name="remind_type" id="remind_type" class="form-control">
                    <option value="day" {{$event->remind_type == "day" ? 'selected' : ''}}>@lang('modules.zoommeeting.day')</option>
                    <option value="hour" {{$event->remind_type == "hour" ? 'selected' : ''}}>@lang('modules.zoommeeting.hour')</option>
                    <option value="minute" {{$event->remind_type == "minute" ? 'selected' : ''}}>@lang('modules.zoommeeting.minute')</option>
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

<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    
        $('#edit-send_reminder').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })


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
    $('#start_time, #end_time').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: true,   // look it
        format: 'HH:mm',
        switchOnClick: true
    });
 $(function() {
        
        
        $('.edit-meeting').click(function () {
            var id = $("#id_field").val();
            var url = "{{ route('admin.zoom-meeting.update', ':id') }}";
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
        @if($event->send_reminder)
            $('#edit-reminder-fields').show(); 
        @endif
        $('#edit-send_reminder').on('ifChecked', function(event){
            $('#edit-reminder-fields').show();
            });
            
            $('#edit-send_reminder').on('ifUnchecked', function(event){
                $('#edit-reminder-fields').hide();
            });

        $('#add_category').click(function () {
            var url = '{{ route('admin.category.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#categoryModal', url);
        
    });
     })
   
</script>
