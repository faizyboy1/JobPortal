@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
    <style>
        .required-field {
            content: " *";
            color: red;
        }
    </style>
@endpush

@section('content')
    @php
        $gender = [
            'male' => __('modules.front.male'),
            'female' => __('modules.front.female'),
            'others' => __('modules.front.others')
        ];
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.edit')</h4>

                    <form class="ajax-form" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4 pl-4 pr-4">
                                <h5>@lang('modules.front.personalInformation')</h5>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">@lang('menu.jobs')</label>
                                    <select name="job_id" id="job_id" onchange="getQuestions(this.value)" class="select2 form-control">
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}" @if ($application->job_id === $job->id) selected @endif>{{ ucwords($job->title).' ('.ucwords($job->location->location).') - ' }}{{ $job->active ? 'Active' : 'Deactive' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label required">@lang('app.name')</label>
                                    <input class="form-control" type="text" value="{{ $application->full_name }}" name="full_name" placeholder="@lang('app.name')">
                                </div>

                                <div class="form-group">
                                    <label class="control-label required">@lang('app.email')</label>
                                    <input class="form-control" type="email" name="email" value="{{ $application->email }}"
                                           placeholder="@lang('app.email')">
                                </div>

                                <div class="form-group">
                                    <label class="control-label required">@lang('app.phone')</label>
                                    <input class="form-control" type="tel" name="phone" value="{{ $application->phone }}"
                                           placeholder="@lang('app.phone')">
                                </div>

                                <div id="show-columns">
                                    @include('admin.job-applications.required-columns', ['job' => $application->job, 'application' => $application, 'gender' => $gender])
                                </div>
                            </div>
                        </div>
                        <div id="show-sections">
                            @include('admin.job-applications.required-sections', ['section_visibility' => $jobs[0]->section_visibility, 'application' => $application])
                        </div>
                        <div class="row">
                            @if(count($jobQuestion) > 0)
                                <div class="col-md-4 pl-4 pr-4 pt-4 b-b" id="questionBoxTitle">
                                    <h5>@lang('modules.front.additionalDetails')</h5>
                                </div>


                                <div class="col-md-8 pt-4 b-b" id="questionBox">

                                </div>
                            @endif
                            <div class="col-md-4 pl-4 pr-4 pt-4">
                                <h5>@lang('app.status')</h5>
                            </div>

                            <div class="col-md-8 pt-4">

                                <div class="form-group">
                                    <select name="status_id" id="status_id" class="select2 form-control">
                                        @foreach($statuses as $status)
                                            <option
                                                    @if($application->status_id == $status->id) selected @endif
                                                    value="{{ $status->id }}">{{ ucwords($status->status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="save-form" class="btn btn-success">
                            <i class="fa fa-check"></i> 
                            @lang('app.save')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        const fetchCountryState = "{{ route('jobs.fetchCountryState') }}";
        const csrfToken = "{{ csrf_token() }}";
        const selectCountry = "@lang('modules.front.selectCountry')";
        const selectState = "@lang('modules.front.selectState')";
        const selectCity = "@lang('modules.front.selectCity')";
        const pleaseWait = "@lang('modules.front.pleaseWait')";

        let country = "{{ $application->country }}";
        let state = "{{ $application->state }}";
    </script>
    <script src="{{ asset('front/assets/js/location.js') }}"></script>
    <script>
        var datepicker = $('.dob').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: (new Date()).toDateString(),
        });

        @if ($application->dob)
            datepicker.datepicker('setDate', new Date('{{ $application->dob }}'))
        @endif
        
        $('.select2').select2({
            width: '100%'
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.job-applications.update', $application->id)}}',
                container: '#editForm',
                type: "POST",
                redirect: true,
                file:true,
                error: function (response) {
                    handleFails(response);
                }
            })
        });

        var val = $('#job_id').val(); // get Current Selected Job
        if (val != '' && typeof val !== 'undefined') {
            getQuestions(val); // get Questions by question on page load
        }

        // get Questions on change Job
        function getQuestions(id) {
            var url = "{{ route('admin.job-applications.question', [':id', $application->id]) }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'GET',
                url: url,
                container: '#editForm',
                success: function (response) {
                    if (response.status == "success") {
                        if (response.count > 0) { // Question Found for selected job
                            $('#questionBox').show();
                            $('#questionBoxTitle').show();
                            $('#questionBox').html(response.view);
                        } else { // Question Not Found for selected job
                            $('#questionBox').hide();
                            $('#questionBoxTitle').hide();
                        }
                        $('#show-columns').html(response.requiredColumnsView);
                        $('#show-sections').html(response.requiredSectionsView);
                        if(response.requiredColumnsView !== '') {
                            var datepicker = $('.dob').datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                endDate: (new Date()).toDateString(),
                            });
                            if (response.application.dob !== null) {
                                $('.dob').datepicker('setDate', new Date(response.application.dob));
                            }
                            
                            $('.select2').select2({
                                width: '100%'
                            });

                            country = response.application.country;
                            state = response.application.state;

                            var loc = new locationInfo()
                            loc.getCountries()
                        }
                    }
                }
            });
        }

        function handleFails(response) {

            if (typeof response.responseJSON.errors != "undefined") {
                var keys = Object.keys(response.responseJSON.errors);
                $('#editForm').find(".has-error").find(".help-block").remove();
                $('#editForm').find(".has-error").removeClass("has-error");

                for (var i = 0; i < keys.length; i++) {
                    // Escape dot that comes with error in array fields
                    var key = keys[i].replace(".", '\\.');
                    var formarray = keys[i];

                    // If the response has form array
                    if(formarray.indexOf('.') >0){
                        var array = formarray.split('.');
                        response.responseJSON.errors[keys[i]] = response.responseJSON.errors[keys[i]];
                        key = array[0]+'['+array[1]+']';
                    }

                    var ele = $('#editForm').find("[name='" + key + "']");

                    var grp = ele.closest(".form-group");
                    $(grp).find(".help-block").remove();

                    //check if wysihtml5 editor exist
                    var wys = $(grp).find(".wysihtml5-toolbar").length;

                    if(wys > 0){
                        var helpBlockContainer = $(grp);
                    }
                    else{
                        var helpBlockContainer = $(grp).find("div:first");
                    }
                    if($(ele).is(':radio')){
                        helpBlockContainer = $(grp);
                    }

                    if (helpBlockContainer.length == 0) {
                        helpBlockContainer = $(grp);
                    }

                    helpBlockContainer.append('<div class="help-block">' + response.responseJSON.errors[keys[i]] + '</div>');
                    $(grp).addClass("has-error");
                }

                if (keys.length > 0) {
                    var element = $("[name='" + keys[0] + "']");
                    if (element.length > 0) {
                        $("html, body").animate({scrollTop: element.offset().top - 150}, 200);
                    }
                }
            }
        }
    </script>
@endpush