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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.createNew')</h4>
                    @if(count($jobs) == 0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h4 class="alert-heading"><i class="fa fa-warning"></i> Warning!</h4>
                            <p>You do not have any job created. You need to create the job first to add the job
                                application.
                                <a href="{{ route('admin.jobs.create') }}" class="btn btn-info btn-sm m-l-15"
                                   style="text-decoration: none;"><i
                                            class="fa fa-plus-circle"></i> @lang('app.createNew') @lang('menu.jobs')</a>
                            </p>
                        </div>
                    @else

                        <form class="ajax-form" method="POST" id="createForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 pl-4 pr-4">
                                    <h5>@lang('modules.front.personalInformation')</h5>
                                </div>


                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="control-label">@lang('menu.jobs')</label>
                                        <select name="job_id" id="job_id" onchange="getQuestions(this.value)"
                                                class="select2 form-control">
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->id }}">{{ ucwords($job->title).' ('.ucwords($job->location->location).')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.name')</label>
                                        <input class="form-control" type="text" name="full_name"
                                               placeholder="@lang('app.name')">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.email')</label>
                                        <input class="form-control" type="email" name="email"
                                               placeholder="@lang('app.email')">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.phone')</label>
                                        <input class="form-control" type="tel" name="phone"
                                               placeholder="@lang('app.phone')">
                                    </div>

                                    <div id="show-columns">
                                        @include('admin.job-applications.required-columns', ['job' => $jobs[0], 'gender' => $gender])
                                    </div>
                                </div>
                            </div>
                            <div id="show-sections">
                                @include('admin.job-applications.required-sections', ['section_visibility' => $jobs[0]->section_visibility])
                            </div>

                            <div class="row">
                                <div class="col-md-4 pl-4 pr-4 pt-4 b-b" id="questionBoxTitle">
                                    <h5>@lang('modules.front.additionalDetails')</h5>
                                </div>

                                <div class="col-md-8 pt-4 b-b" id="questionBox">

                                </div>
                            </div>

                            <br>
                            <button type="button" id="save-form" class="btn btn-success"><i
                                        class="fa fa-check"></i> @lang('app.save')</button>

                        </form>
                    @endif
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

        let country = "";
        let state = "";
    </script>
    <script src="{{ asset('front/assets/js/location.js') }}"></script>
    <script>
        var datepicker = $('.dob').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: (new Date()).toDateString(),
        });
        
        $('.select2').select2({
            width: '100%'
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.job-applications.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file: true,
                data: $('#createForm').serialize(),
                error: function (response) {
                    handleFails(response);
                }
            })
        });

        var val = $('#job_id').val(); // get Current Selected Job
        if (val != '' && typeof(val) !== 'undefined') {
            getQuestions(val); // get Questions by question on page load            
        }

        // get Questions on change Job
        function getQuestions(id) {
            var url = "{{ route('admin.job-applications.question',':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'GET',
                url: url,
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
                            
                            $('.select2').select2({
                                width: '100%'
                            });

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
                console.log(keys);
                $('#createForm').find(".has-error").find(".help-block").remove();
                $('#createForm').find(".has-error").removeClass("has-error");

                for (var i = 0; i < keys.length; i++) {
                    // Escape dot that comes with error in array fields
                    var key = keys[i].replace(".", '\\.');
                    var formarray = keys[i];

                    // If the response has form array
                    if (formarray.indexOf('.') > 0) {
                        var array = formarray.split('.');
                        response.responseJSON.errors[keys[i]] = response.responseJSON.errors[keys[i]];
                        key = array[0] + '[' + array[1] + ']';
                    }

                    var ele = $('#createForm').find("[name='" + key + "']");

                    var grp = ele.closest(".form-group");
                    $(grp).find(".help-block").remove();

                    //check if wysihtml5 editor exist
                    var wys = $(grp).find(".wysihtml5-toolbar").length;

                    if (wys > 0) {
                        var helpBlockContainer = $(grp);
                    } else {
                        var helpBlockContainer = $(grp).find("div:first");
                    }
                    if ($(ele).is(':radio')) {
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