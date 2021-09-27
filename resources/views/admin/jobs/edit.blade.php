@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush


@section('content')
    @php
        $requiredColumns = [
            'gender' => __('modules.front.gender'),
            'dob' => __('modules.front.dob'),
            'country' => __('modules.front.country')
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
                    <h4 class="card-title mb-4">@lang('app.edit')</h4>

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('app.company')</label>
                                    <select name="job_company_id" id="job_company_id"
                                            class="form-control">
                                            @foreach ($jobCompanies as $comp)
                                            <option @if($comp->id == $job->job_company_id) selected @endif value="{{ $comp->id }}">{{ ucwords($comp->company_name) }}</option> 
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobTitle')</label>
                                    <input type="text" class="form-control" name="title" value="{{ $job->title }}">
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobDescription')</label>
                                    <textarea class="form-control" id="job_description" name="job_description" rows="15" placeholder="Enter text ...">{!! $job->job_description !!}</textarea>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobRequirement')</label>
                                    <textarea class="form-control" id="job_requirement" name="job_requirement" rows="15" placeholder="Enter text ...">{!! $job->job_requirement !!}</textarea>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('menu.locations')</label>
                                    <select name="location_id" id="location_id"
                                            class="form-control select2 custom-select">
                                        @foreach($locations as $location)
                                            <option
                                                    @if($location->id == $job->location_id) selected @endif
                                                    value="{{ $location->id }}">{{ ucfirst($location->location). ' ('.$location->country->country_code.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('menu.jobCategories')</label>
                                    <select name="category_id" id="category_id"
                                            class="form-control">
                                        @foreach($categories as $category)
                                            <option
                                                    @if($category->id == $job->category_id) selected @endif
                                            value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>@lang('menu.skills')</label>
                                    <select class="select2 m-b-10 select2-multiple" id="job_skills" style="width: 100%; " multiple="multiple"
                                            data-placeholder="@lang('app.add') @lang('menu.skills')" name="skill_id[]">
                                        @foreach($skills as $skill)
                                            <option
                                                    @foreach($job->skills as $jskill)
                                                        @if($skill->id == $jskill->skill_id)
                                                            selected
                                                        @endif
                                                    @endforeach
                                                    value="{{ $skill->id }}">{{ ucwords($skill->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.totalPositions')</label>
                                    <input type="number" class="form-control" name="total_positions" id="total_positions" value="{{ $job->total_positions }}">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.startDate')</label>
                                    <input type="text" class="form-control" id="date-start" value="{{ $job->start_date->format('Y-m-d') }}" name="start_date">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.endDate')</label>
                                    <input type="text" class="form-control" id="date-end" name="end_date" value="{{ $job->end_date->format('Y-m-d') }}">
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="address">@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option
                                                @if($job->status == 'active') selected @endif
                                                value="active">@lang('app.active')</option>
                                        <option
                                                @if($job->status == 'inactive') selected @endif
                                        value="inactive">@lang('app.inactive')</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta-title">@lang('modules.jobs.metaTitle')</label>
                                    <input type="text" id="meta-title" class="form-control" name="meta_title" value="{{ $job->meta_details['title'] }}">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta-description">@lang('modules.jobs.metaDescription')</label>
                                    <textarea id="meta-description" class="form-control" name="meta_description" rows="3">{{ $job->meta_details['description'] }}</textarea>
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
                                                <input  @if(in_array($question->id, $jobQuestion)) checked @endif type="checkbox" value="{{$question->id}}" name="question[]" class="flat-red"  style="position: absolute; opacity: 0;">
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
                                    @if ($job->required_columns)
                                        @foreach ($job->required_columns as $key => $value)
                                            <label class="mr-4">
                                                <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                    <input  @if($value) checked @endif type="checkbox" value="{{ $key }}" name="{{ $key }}" class="flat-red"  style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                </div>
                                                {{ ucfirst(__($requiredColumns[$key])) }}
                                            </label>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>        
                            </div>

                            <div class="col-md-12">
                                <div id="columns">
                                    <label>@lang('modules.jobs.sectionVisibility')</label>
                                    <div class="form-group form-group-inline">
                                        @foreach ($job->section_visibility as $key => $value)
                                        <label class="mr-4">
                                            <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false"
                                                style="position: relative;">
                                                <input @if($value == 'yes') checked @endif type="checkbox" value="yes"
                                                    name="{{ $key }}" class="flat-red"
                                                    style="position: absolute; opacity: 0;">
                                                <ins class="iCheck-helper"
                                                    style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"
            type="text/javascript"></script>
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
                url: '{{route('admin.jobs.update', $job->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize()
            })
        });


    </script>
@endpush