@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
@endpush

@section('content')
    @php
        $required_columns = [
            'gender' => false,
            'dob' => false,
            'country' => false
        ];
        $requiredColumns = [
            'gender' => __('modules.front.gender'),
            'dob' => __('modules.front.dob'),
            'country' => __('modules.front.country')
        ];
        $section_visibility = [
            'profile_image' => 'yes',
            'resume' => 'yes',
            'cover_letter' => 'yes',
            'terms_and_conditions' => 'yes'
        ];
        $sectionVisibility = [
            'profile_image' => __('modules.jobs.profileImage'),
            'resume' => __('modules.jobs.resume'),
            'cover_letter' => __('modules.jobs.coverLetter'),
            'terms_and_conditions' => __('modules.jobs.termsAndConditions')
        ];
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.createNew')</h4>
                    @if(count($locations) == 0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h4 class="alert-heading"><i class="fa fa-warning"></i> Job Location Empty!</h4>
                            <p>You do not have any Location created. You need to create the Job location first to add
                                the job .
                                <a href="{{ route('admin.locations.create') }}" class="btn btn-info btn-sm m-l-15"
                                   style="text-decoration: none;"><i
                                            class="fa fa-plus-circle"></i> @lang('app.createNew') @lang('menu.locations')
                                </a>
                            </p>
                        </div>
                    @elseif(count($categories) == 0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h4 class="alert-heading"><i class="fa fa-warning"></i> Job Category Empty!</h4>
                            <p>You do not have any Job Category created. You need to create the Job location first to add
                                the job .
                                <a href="{{ route('admin.job-categories.create') }}" class="btn btn-info btn-sm m-l-15"
                                   style="text-decoration: none;"><i
                                            class="fa fa-plus-circle"></i> @lang('app.createNew') @lang('menu.jobCategories')
                                </a>
                            </p>
                        </div>
                    @else

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.company')</label>
                                    <select name="job_company_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach ($jobCompanies as $comp)
                                            <option value="{{ $comp->id }}">{{ ucwords($comp->company_name) }}</option> 
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address" class="required">@lang('modules.jobs.jobTitle')</label>
                                    <input type="text" class="form-control" name="title">
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address"  class="required">@lang('modules.jobs.jobDescription')</label>
                                    <textarea class="form-control" id="job_description" name="job_description" rows="15" placeholder="Enter text ..."></textarea>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address" class="required">@lang('modules.jobs.jobRequirement')</label>
                                    <textarea class="form-control" id="job_requirement" name="job_requirement" rows="15" placeholder="Enter text ..."></textarea>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('menu.locations')</label>
                                    <select name="location_id" id="location_id"
                                            class="form-control select2 custom-select">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ ucfirst($location->location). ' ('.$location->country->country_code.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address" class="required">@lang('menu.jobCategories')</label>
                                    <select name="category_id" id="category_id"
                                            class="form-control">
                                        <option value="">@lang('app.choose') @lang('menu.jobCategories')</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>@lang('menu.skills')</label>
                                    <select class="select2 m-b-10 select2-multiple" id="job_skills" style="width: 100%; " multiple="multiple"
                                            data-placeholder="@lang('app.add') @lang('menu.skills')" name="skill_id[]">
                                    </select>
                                </div>


                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address" class="required">@lang('modules.jobs.totalPositions')</label>
                                    <input type="number" class="form-control" name="total_positions" id="total_positions">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.startDate')</label>
                                    <input type="text" class="form-control" id="date-start" value="{{ \Carbon\Carbon::now(company()->timezone)->format('Y-m-d') }}" name="start_date">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.endDate')</label>
                                    <input type="text" class="form-control" id="date-end" name="end_date" value="{{ \Carbon\Carbon::now(company()->timezone)->addMonth(1)->format('Y-m-d') }}">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="startTime">@lang('modules.jobs.startTimeSlot')</label>
                                    <input type="text" class="form-control" id="start-time-slot" name="start_time_slot">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="endTime">@lang('modules.jobs.endTimeSlot')</label>
                                    <input type="text" class="form-control" id="end-time-slot" name="end_time_slot">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">@lang('app.active')</option>
                                        <option value="inactive">@lang('app.inactive')</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta-title">@lang('modules.jobs.metaTitle')</label>
                                    <input type="text" id="meta-title" class="form-control" name="meta_title">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta-description">@lang('modules.jobs.metaDescription')</label>
                                    <textarea id="meta-description" class="form-control" name="meta_description" rows="3"></textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                @if(count($questions) > 0)
                                <h4 class="m-b-0 m-l-10 box-title">@lang('modules.front.questions')</h4>
                                @endif
                                @forelse($questions as $question)
                                    <div class="form-group col-md-6">
                                        <label class="">
                                            <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                <input type="checkbox" value="{{$question->id}}" name="question[]" class="flat-red"  style="position: absolute; opacity: 0;">
                                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                            </div>
                                            {{ ucfirst($question->question)}} @if($question->required == 'yes')(@lang('app.required'))@endif
                                        </label>
                                    </div>
                                @empty
                                @endforelse
                            </div>

                            <div class="col-md-12">
                                <div id="columns">
                                    <label>@lang('app.askApplicantsFor')</label>
                                    <div class="form-group form-group-inline">
                                        @foreach ($required_columns as $key => $value)
                                            <label class="mr-4">
                                                <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                    <input  @if($value) checked @endif type="checkbox" value="{{ $key }}" name="{{ $key }}" class="flat-red"  style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                </div>
                                                {{ ucfirst(__($requiredColumns[$key])) }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>        
                            </div>

                            <div class="col-md-12">
                                <div id="columns">
                                    <label>@lang('modules.jobs.sectionVisibility')</label>
                                    <div class="form-group form-group-inline">
                                        @foreach ($section_visibility as $key => $value)
                                            <label class="mr-4">
                                                <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                    <input  @if($value == 'yes') checked @endif type="checkbox" value="yes" name="{{ $key }}" class="flat-red"  style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                </div>
                                                {{ ucfirst(__($sectionVisibility[$key])) }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>        
                            </div>
                        </div>

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
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })

        // For select 2
        $(".select2").select2();

        $('#date-end').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#start-time-slot').bootstrapMaterialDatePicker({ date: false, format : 'HH:mm', shortTime:false });
        $('#end-time-slot').bootstrapMaterialDatePicker({ date: false, format : 'HH:mm', shortTime:false });
        $('#date-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false }).on('change', function(e, date)
        {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });

        var jobDescription = $('#job_description').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)
        });

        $('#job_requirement').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)

        });

        $('#category_id').change(function () {

            var id = $(this).val();

            var url = "{{route('admin.job-categories.getSkills', ':id')}}";
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                success: function (response) {
                    $('#job_skills').html(response.data);
                    $(".select2").select2();
                }
            })
        });


        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.jobs.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize(),
            })
        });


    </script>
@endpush