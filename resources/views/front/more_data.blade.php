    @forelse($jobs as $job)
            <div class="col-12 col-md-6 col-lg-4" data-shuffle="item" data-groups="{{ $job->location->location.','.$job->category->name }}">
                <a href="{{ route('jobs.jobDetail', [$job->slug]) }}" class="job-opening-card">
                <div class="card card-bordered">
                    <div class="card-block">

                        <h5 class="card-title mb-0">{{ ucwords($job->title) }}</h5>
                        @if($job->company->show_in_frontend == 'true')
                            <small class="company-title mb-50">@lang('app.by') {{ ucwords($job->company->company_name) }}</small>
                        @endif
                        <div class="d-flex flex-wrap justify-content-between card-location">
                            <span class="fw-400 fs-14"><i class="mr-5 fa fa-map-marker"></i>{{ ucwords($job->location->location).', '.ucwords($job->location->country->country_name) }}</span>
                            <span class="fw-400 fs-14">{{ ucwords($job->category->name) }}<i class="ml-5 fa fa-graduation-cap"></i></span>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @empty
            <div class="col-md-12">
               <h6 class="text-center">   @lang('modules.front.noData')</h6>
            </div>
        @endforelse