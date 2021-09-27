@extends('layouts.app')
@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">

    <style>
        .p-10{
            padding: 10px;
        }
        .select-file {
            height:40px;
            padding: 6px !important;
        }
        .form-control {
            height:40px !important;
        }
        .ml-10 {
           margin-left: 10px;
        }
        .hide-box {
            display: none;
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"> @lang('app.job') @lang('app.onBoard')</h4>
                    <form id="createSchedule" class="ajax-form" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6  col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('modules.interviewSchedule.candidate') @lang('app.name')</label>
                                        <p>{{ $application->full_name }}</p>
                                        <input type="hidden" name="candidate_id" value="{{ $application->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6  col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('modules.interviewSchedule.candidate') @lang('app.phone') </label>
                                        <p>{{ $application->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('modules.interviewSchedule.candidate') @lang('app.email')</label>
                                        <p>{{ $application->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.job') @lang('app.location') </label>
                                        <p>{{ ucwords($application->job->location->location) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.department')
                                            <a href="javascript:;" title="@lang('app.add') @lang('app.department')"
                                               id="addDepartment"
                                               class="btn btn-sm  btn-info btn-outline"><i class="fa fa-gear"></i></a>
                                        </label>
                                        <select class="select2 m-b-10 form-control select2 "
                                                data-placeholder="@lang('app.choose') @lang('app.department')" data-placeholder="@lang('app.department')" name="department" id="department">
                                            @foreach($departments as $department)
                                                <option @if($department->id == $onboard->department_id) selected @endif value="{{ $department->id }}">{{ ucwords($department->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.designation')
                                            <a href="javascript:;" title="@lang('app.add') @lang('app.designation')"
                                               id="addDesignation"
                                               class="btn btn-sm btn-outline btn-info"><i class="fa fa-gear"></i></a>
                                        </label>
                                        <select class="select2 m-b-10 form-control select2 "
                                                data-placeholder="@lang('app.choose') @lang('app.designation')" data-placeholder="@lang('app.designation')" name="designation" id="designation">
                                            @foreach($designations as $designation)
                                                <option @if($designation->id == $onboard->designation_id) selected @endif value="{{ $designation->id }}">{{ ucwords($designation->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.salaryOfferedPerMonth')</label>
                                        <input type="number" class="form-control" min="0" name="salary" value="{{ $onboard->salary_offered }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.joinDate')</label>
                                        <input type="text" class="form-control datepicker" name="join_date" id="join_date" value="{{ $onboard->joining_date->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.employeeWorkStatus')</label>
                                        <select class="m-b-10 form-control"
                                                data-placeholder="@lang('app.employeeWorkStatus')" data-placeholder="@lang('app.employeeWorkStatus')" name="employee_status">
                                                <option @if($onboard->employee_status == 'part_time') selected @endif  value="part_time">@lang('app.partTime')</option>
                                                <option @if($onboard->employee_status == 'full_time') selected @endif  value="full_time">@lang('app.fullTime')</option>
                                                <option @if($onboard->employee_status == 'on_contract') selected @endif  value="on_contract">@lang('app.onContract')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.reportTo')</label>
                                        <select class="select2 m-b-10 form-control select2"
                                                data-placeholder="@lang('app.reportTo')" data-placeholder="@lang('app.reportTo')" name="report_to">
                                            @foreach($users as $emp)
                                                <option  @if($emp->id == $onboard->reports_to_id) selected @endif  value="{{ $emp->id }}">{{ ucwords($emp->name) }} @if($emp->id == $user->id)
                                                        (@lang('app.you')) @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.lastDate')</label>
                                        <input type="text" class="form-control datepicker" name="last_date" id="last_date" value="{{ $onboard->joining_date->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.status')</label>
                                        <select class="m-b-10 form-control" onchange="checkStatus(this.value)"
                                                data-placeholder="@lang('app.status')" data-placeholder="@lang('app.status')" name="status">
                                            <option @if($onboard->hired_status == 'accepted') selected @endif  value="accepted">@lang('app.accepted')</option>
                                            <option @if($onboard->hired_status == 'offered') selected @endif  value="offered">@lang('app.offered')</option>
                                            <option @if($onboard->hired_status == 'rejected') selected @endif  value="rejected">@lang('app.rejected')</option>
                                            <option @if($onboard->hired_status == 'canceled') selected @endif  value="canceled">@lang('app.canceled')</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="reasonBox" class="col-md-12 @if($onboard->hired_status == 'offered' || $onboard->hired_status == 'accepted') hide-box @endif">
                                    <div class="form-group">
                                        <label class="d-block">@lang('app.reason') {{ $onboard->hired_status }}</label>
                                        <textarea class="form-control" rows="5" name="reason"> </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="theme-color mt-20">@lang('app.files')</h4>

                                    <div class="row">
                                        @forelse($onboard->files as $file)
                                            <input type="hidden" name="oldImages[{{$file->id}}]">
                                            <div class="col-md-2 m-b-10" id="fileBox{{$file->id}}">
                                                <a target="_blank" href="{{ asset_url('onboard-files/'.$file->hash_name) }}">
                                                    <div class="card">
                                                        <div class="file-bg">
                                                            <div class="overlay-file-box">
                                                                <div class="user-content">
                                                                    @if(array_key_exists($file->ext, $imageExt))
                                                                        <img class="card-img-top img-responsive" src="{{ asset_url('onboard-files/'.$file->hash_name) }}" >
                                                                    @else
                                                                        <i class="fa {{ $fileExt[$file->ext]}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-block">
                                                            <h6 class="card-title">{{ $file->name }}</h6>
                                                            <a href="javascript:;" data-toggle="tooltip"
                                                               data-original-title="Delete"
                                                               data-file-id="{{ $file->id }}"
                                                               class="btn btn-danger btn-circle sa-params" data-pk="thumbnail"><i
                                                                        class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty

                                        @endforelse
                                    </div>
                                <div class="row p-10">
                                    <label class="d-block ml-10">@lang('app.offer') @lang('app.files') </label>
                                    <div id="addMoreBox1" class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div id="dateBox" class="form-group ">
                                                            <input type="text" name="name[]" class="form-control file-input" placeholder="@lang('app.file') @lang('app.name')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <input class="form-control select-file file-input" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf" type="file" name="file[]"><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1" style="margin-top: 66px">

                                            </div>
                                        </div>

                                    </div>
                                    <div id="insertBefore"></div>
                                    <div class="clearfix">

                                    </div>

                                    <div class="col-md-12">
                                        <button type="button" id="plusButton" class="btn btn-sm btn-info" style="margin-bottom: 20px">
                                            @lang('app.addMore') @lang('app.files') <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <button type="button" class="btn btn-success save-onboard"><i
                                        class="fa fa-check"></i> @lang('app.save')</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--Ajax Modal Start for--}}
    <div class="modal fade bs-modal-md in" id="addDepartmentModal" role="dialog" aria-labelledby="myModalLabel"
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
@endsection

@push('footer-script')
<script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>


<script>

    // Select 2 init.
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());

    });
    // Datepicker set
    $('#join_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
    });

    // Datepicker set
    $('#last_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
    });

    function checkStatus(val){
        if(val == 'accepted' || val == 'offered'){
            $('#reasonBox').hide();
        }
        else{
            $('#reasonBox').show();
        }
    }

    // Save Interview Schedule
    $('.save-onboard').click(function () {
        $.easyAjax({
            url: '{{route('admin.job-onboard.update', $onboard->id)}}',
            container: '#createSchedule',
            type: "POST",
            file: true,
            success: function (response) {
                if(response.status == 'success'){
                    // window.location.reload();
                }
            }
        })
    })

    $('#addDepartment').click(function () {
        var url = "{{ route('admin.departments.create') }}";
        $('#modelHeading').html('Department');
        $.ajaxModal('#addDepartmentModal', url);
    });

    $('#addDesignation').click(function () {
        var url = "{{ route('admin.designations.create') }}";
        $('#modelHeading').html('Designation');
        $.ajaxModal('#addDepartmentModal', url);
    });

    var $insertBefore = $('#insertBefore');
    var $i = 0;

    // Add More Inputs
    $('#plusButton').click(function(){

        $i = $i+1;
        var indexs = $i+1;
        $(' <div id="addMoreBox'+indexs+'" class="col-md-12"> ' +
            '<div class="row">' +
            '<div class="col-md-11">' +
            '<div class="row">' +
            '<div class="col-md-5">' +
            '<div id="dateBox" class="form-group ">' +
            '<input type="text" name="name['+$i+']" class="form-control file-input" placeholder="@lang('app.file') @lang('app.name')">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-5">' +
            '<div class="form-group">' +
            '<input class="form-control select-file file-input" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf" type="file" name="file[]"><br>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-1">' +
            '<button type="button"  onclick="removeBox('+indexs+')"  class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
            '</div>' +
            '</div>').insertBefore($insertBefore);

    });

    // Remove fields
    function removeBox(index){
        $('#addMoreBox'+index).remove();
    }

    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('file-id');
        var deleteView = $(this).data('pk');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "{{ route('admin.job-onboard.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'DELETE', 'view': deleteView},
                    success: function (response) {
                        console.log(response);
                        if (response.status == "success") {
                            $.unblockUI();
                            $('#fileBox'+id).fadeOut();
                        }
                    }
                });
            }
        });
    });
</script>

@endpush

