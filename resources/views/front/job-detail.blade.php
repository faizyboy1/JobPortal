@extends('layouts.front')
<style>
    .header.inner-header{
        height: 274px;
    }
    .header {
        padding: 104px 100px !important;
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

@section('content')
<section class="section pb-40">
    <div class="container">
        <div class="row">

            <div class="col-lg-9 col-md-7">
                
                    <div class="bg-white p-15">
                        <div class="col-md-12">
                            <h4 class="mt-10">{{ ucwords($job->title) }}</h4>
                            <!-- @if($job->company->show_in_frontend == 'true')
                                <small class="company-title">@lang('app.by') {{ ucwords($job->company->company_name) }}</small>
                            @endif
                            <p>{{ ucwords($job->category->name) }}</p> -->

                            @if(count($job->skills) > 0)
                                <h6>@lang('menu.skills')</h6>
                                <div class="gap-multiline-items-1">
                                    @foreach($job->skills as $skill)
                                        <span class="badge badge-secondary">{{ $skill->skill->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <p class="mt-30 fw-500 fs-16 text-dark">@lang('modules.jobs.jobDescription')</p>

                            <div class="fw-400 text-color text-justify fs-16">
                                {!! $job->job_description !!}
                            </div>

                            <p class="mt-30 fw-500 fs-16 text-dark">@lang('modules.jobs.jobRequirement')</p>

                            <div class="fw-400 text-color text-justify fs-16" >
                                {!! $job->job_requirement !!}
                            </div>

                            <!-- <div class="my-30 text-center">
                                <a class="btn btn-lg btn-primary theme-background"
                                href="{{ route('jobs.jobApply', $job->slug) }}">@lang('modules.front.applyForJob')</a>
                            </div> -->

                        </div>

                    </div>
               
            </div>

            <div class="col-lg-3 col-md-5">
                <div class="sidebar bg-white" id="sidebar">

                    <div class="p-30 bb-1">
                        <p class="fw-500 fs-16 text-dark mb-0">@lang('menu.writtenBy')</p>
                        <p class="fw-400 text-color fs-16 mb-0 company-title">
                            @if($job->company->show_in_frontend == 'true')
                                @lang('app.by') {{ ucwords($job->company->company_name) }}
                            @endif
                        </p>
                    </div>

                    <div class="p-30 bb-1">
                        <p class="fw-500 fs-16 text-dark mb-0">@lang('menu.locations')</p>
                        <p class="fw-400 text-color fs-16 mb-0">{{ ucwords($job->location->location) }}</p>
                    </div>

                    <div class="p-30 bb-1">
                        <p class="fw-500 fs-16 text-dark mb-0">@lang('app.category')</p>
                        <p class="fw-400 text-color fs-16 mb-0">{{ ucwords($job->category->name) }}</p>
                    </div>
                    @if(count($job->skills) > 0)
                        <div class="p-30 bb-1">
                            <p class="fw-500 fs-16 text-dark mb-0">@lang('menu.skills')</p>
                            @foreach($job->skills as $skill)
                            <p class="fw-400 text-color fs-16 mb-0">{{ $skill->skill->name }}</p>
                            @endforeach
                         </div>
                    @endif

                    <div class="p-30 bb-1">
                        <a class="btn btn-block btn-primary theme-background"
                       href="{{ route('jobs.jobApply', $job->slug) }}">@lang('modules.front.applyForJob')</a>
                    </div>

                   <div class="border-light mt-20 text-center py-10">
                        <span class="fs-12 fw-600">@lang('modules.front.shareJob')</span>

                        <div class="social social-boxed social-colored social-cycling text-center my-10">
                            <a class="social-linkedin"
                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('jobs.jobDetail', [$job->slug]) }}&title={{ urlencode(ucwords($job->title)) }}&source=LinkedIn"
                            ><i class="fa fa-linkedin"></i></a>
                            <a class="social-facebook"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-facebook"></i></a>
                            <a class="social-twitter"
                               href="https://twitter.com/intent/tweet?status={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-twitter"></i></a>
                            <a class="social-gplus"
                               href="https://plus.google.com/share?url={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                    @if($linkedinGlobal->status == "enable")
                        <a class="my-10 applyWithLinkedin btn btn-block btn-primary " href="{{ route('jobs.linkedinRedirect', 'linkedin') }}">
                            <i class="fa fa-linkedin-square"></i>
                            @lang('modules.front.linkedinSignin')
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection