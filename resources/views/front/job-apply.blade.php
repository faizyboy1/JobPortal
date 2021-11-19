@extends('layouts.front')
<style>
    .header.inner-header{
        height: 435px;
    }
    
    @media (max-width:767px) {
        .header.inner-header {
            height: 224px;
        }
    }
    
    </style>
@section('header-text')
<h1 class="hidden-sm-down text-white fs-40 mb-10">{{ ucwords($job->title) }}</h1>
<h3 class="hidden-sm-up text-white  mb-10">{{ ucwords($job->title) }}</h3>
<div class="text-white">
    <a class="text-white" href="{{ route('jobs.jobOpenings') }}"><u>@lang('modules.front.jobOpenings')</u>&nbsp; </a> &raquo; &nbsp;<span class="text-white">{{ ucwords($job->title) }}</span>
</div>
@endsection

@push('header-css')
<style>
 .required:after { content:" *";color: crimson;}

 </style>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')
    @php
        $gender = [
            'male' => __('modules.front.male'),
            'female' => __('modules.front.female'),
            'others' => __('modules.front.others')
        ];
    @endphp

    <form id="createForm" method="POST">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">

        <div class="container">
        <div class="row gap-y">
            {{-- <div class="col-md-12 fs-12 pt-50 pb-10 bb-1 mb-20">

                <a class="text-dark"
                   href="{{ route('jobs.jobOpenings') }}">@lang('modules.front.jobOpenings')</a> &raquo; <a
                        class="text-dark"
                        href="{{ route('jobs.jobDetail', [$job->slug]) }}">{{ ucwords($job->title) }}</a> &raquo; <span
                        class="theme-color">@lang('modules.front.applicationForm')</span>
            </div> --}}
            <div class="col-md-4 px-20 pb-30 mt-50">
                <h5>@lang('modules.front.personalInformation')</h5>
            </div>

            <div class="col-md-8 pb-30 mt-50">

                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="full_name" placeholder="@lang('modules.front.fullName')" value="@if($user) {{ $user->name }} @endif">
                </div>

                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email"
                            placeholder="@lang('modules.front.email')" value="@if($user) {{ $user->email }} @endif">
                </div>

                <div class="form-group">
                    <input class="form-control form-control-lg" type="tel" name="phone"
                            placeholder="@lang('modules.front.phone')">
                </div>

                @if ($job->required_columns['gender'])
                    <label class="control-label">@lang('modules.front.gender')</label>
                    <div class="form-group">
                        <div class="form-inline">
                            @foreach ($gender as $key => $value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="{{ $key }}" value="{{ $key }}">
                                    <label class="form-check-label" for="{{ $key }}">{{ ucFirst($value) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($job->required_columns['dob'])
                    <div class="form-group">
                        <input class="form-control form-control-lg dob" type="text" name="dob"
                                placeholder="@lang('modules.front.dob')" autocomplete="none">
                    </div>
                @endif
                @if ($job->required_columns['country'])
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="select2 countries" name="country" id="countryId">
                                    <option value="0">@lang('modules.front.selectCountry')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="select2 states" name="state" id="stateId">
                                    <option value="0">@lang('modules.front.selectState')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input class="form-control form-control-lg" type="text" name="city" id="cityId" placeholder="@lang('modules.front.selectCity')">
                            </div>
                        </div>
                    </div>
                @endif

               
                 <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Please Selece Interview Time Slots To Appear</h6>
                                    <select class="select2" name="interviewTimeSlot" id="interviewTimeSlot">
                                        
                                        <option >@lang('modules.front.selectTimeSlot')</option>
                                        @foreach ($slots1 as $slot =>$value)
                                        <option value="{{$value}}">{{$value}}</option>
                                        @endforeach

                                    </select>
                            </div>
                        </div>
                 </div> 
                

                @if($job->section_visibility['profile_image'] == 'yes')
                    <div class="form-group">
                        <h6>@lang('modules.front.photo')</h6>
                        <img src="@if($user) {{ $user->avatar }} @endif">
                        <input type="hidden" name="linkedinPhoto" value="@if($user) {{ $user->avatar }} @endif">
                        @if($user)
                            <input type="hidden" name="apply_type" value="linkedin">
                        @endif
                        <input class="select-file" accept=".png,.jpg,.jpeg" type="file" name="photo"><br>
                        <span>@lang('modules.front.photoFileType')</span>
                    </div>
                @endif
            </div>

            @if (isset($job->section_visibility['resume']) &&$job->section_visibility['resume'] == 'yes')
                <div class="col-md-4 px-20 pb-30 bt-1">
                    <h5>@lang('modules.front.resume')</h5>
                </div>
                <div class="col-md-8 py-30 bt-1">
                    <div class="form-group">
                        <input class="select-file" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf" type="file" name="resume"><br>
                        <span>@lang('modules.front.resumeFileType')</span>
                    </div>
                </div>
            @endif
            @if(count($jobQuestion) > 0)
                <div class="col-md-4 px-20 pb-30 bt-1">
                    <h5>@lang('modules.front.additionalDetails')</h5>
                </div>

                <div class="col-md-8 pb-30 bt-1">
                    @foreach($jobQuestion as $question)
                        <div class="form-group">
                            <label class="control-label" for="answer[{{ $question->id}}]">{{ $question->question }}</label>
                            <input class="form-control form-control-lg" type="text" id="answer[{{ $question->id}}]" name="answer[{{ $question->id}}]" placeholder="@lang('modules.front.yourAnswer')">
                        </div>
                    @endforeach

                </div>
            @endif

            @if (isset($job->section_visibility['cover_letter']) && $job->section_visibility['cover_letter'] == 'yes')
                <div class="col-md-4 px-20 pb-30 bt-1">
                    <h5>@lang('modules.front.coverLetter')</h5>
                </div>
                <div class="col-md-8 py-30 bt-1">
                    <div class="form-group">
                        <textarea class="form-control form-control-lg" name="cover_letter" rows="4"></textarea>
                    </div>
                </div>
            @endif

            @if (isset($job->section_visibility['terms_and_conditions']) && $job->section_visibility['terms_and_conditions'] == 'yes')
                <div class="col-md-4 px-20 pb-30 bt-1">
                    <h5>@lang('modules.front.legalTerm')</h5>
                </div>
                <div class="col-md-8 py-30 bt-1">
                    <div class="form-group">
                        <div class="form-control form-control-lg legal-term">
                            {!! !is_null($applicationSetting) ? $applicationSetting->legal_term : '' !!}
                        </div>
                    </div>
                    <div class="form-group mt-30">
                        <div class="switchery-demo mr-20 d-inline-block" >
                            <input type="checkbox" class="js-switch clearfix" id="agree_term"  value="yes"  data-size="small"  name="term_agreement"  data-color="#00c292" />
                            <label for="term_agreement" class="align-top" ><b>@lang('modules.front.agreeWithTerm')</b></label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12 pb-30">
                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">@lang('modules.front.submitApplication')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    </script>
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
    {{--@if($linkedin)
        <script>
            var url = "https://www.linkedin.com/oauth/v2/accessToken";
            jQuery.ajax({
                url:url,
                type:"POST",
                dataType: 'JSON',
                headers: {
                    "content-type":"application/x-www-form-urlencoded"
                },
                data: {
                    'grant_type':"authorization_code",
                    "code":"{{ $reqcode }}",
                    "redirect_uri":"https://facc3d48.ngrok.io/linkedin/callback",
                    "client_id":"81kcuudov7xi9e",
                    "client_secret":"08KsSl8zghlZSXcW",
                },
                success: function (data) {
                    console.log(data);
                }
            });
        </script>
    @endif--}}
    <script>
        $('.dob').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: (new Date()).toDateString(),
        });

        
        $('.select2').select2({
            width: '100%'
        });
        
        $('.form-group span.select2.select2-container').addClass('form-control form-control-lg');
        
        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('jobs.saveApplication')}}',
                container: '#createForm',
                type: "POST",
                file:true,
                redirect: true,
                //  data: $('#createForm').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        var successMsg = '<div class="alert alert-success my-100" role="alert">' +
                            response.msg + ' <a class="" href="{{ jobOpenings($global->career_page_link) }}">{{ __("app.view").' '.__("modules.front.jobOpenings") }} <i class="fa fa-arrow-right"></i></a>'
                            '</div>';
                        $('.main-content .container').html(successMsg);
                        $('.main-content').css('bg', '#ffffff');
                    }
                },
                error: function (response) {
                    handleFails(response);
                }
            })
        });

        function handleFails(response) {
            console.log(response.responseJSON.errors)
            if (typeof response.responseJSON.errors != "undefined") {
                var keys = Object.keys(response.responseJSON.errors);

                $('#createForm').find(".has-error").find(".help-block").remove();
                $('#createForm').find(".has-error").removeClass("has-error");

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

                        var ele = $('#createForm').find("[name='" + key + "']");

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