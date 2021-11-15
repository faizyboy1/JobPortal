
<div data-provide="shuffle" id="applicant-notes">
        
                    <div class="row gap-y">
                    
                        @forelse($companies as $company)
                           
                                <div class="col-12 col-md-6 col-lg-4 portfolio-2" data-shuffle="item">

                                    {{-- <a href="{{ route('jobs.jobDetail', [$jobs->slug]) }}" class="job-opening-card">  --}}
                                    <a href="{{ url('job-companies/'.$company->id) }}" target="_blank"
                                        class="job-opening-card">
                                    
                                        <div class="card card-bordered">
                                            <div class="card-block">
                                                <h5 class="card-title mb-0"></h5>
                                                @if($company->show_in_frontend == 'true')
                                                    <h3 class="company-title mb-5 text-center"> {{ ucwords($company->company_name) }}</h3>
                                                @endif
                                                <div class="text-center">
                                                    <img src="{{asset('user-uploads/company-logo/'.$company->logo)}}" class="img-fluid mb-3" style="height: 60px; width : 180px;">
                                                </div>
                                                <div class="d-flex flex-wrap justify-content-center card-location">
                                                    <span class="fw-400 fs-16" style="color : #ab9594;"><i class="mr-5 fa fa-map-marker"></i>{{ ucwords($company->address) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                             
                            @empty
                            <h4 id ="no-data" class="mx-auto mt-50 mb-40 card-title mb-0" >@lang('modules.front.noData') </h4>
                                
                                @endforelse
                            </div>
                            @if(!$companies->isEmpty())
                                <div class="row gap-y">
                                    <button type="button" name="load_more_button" class="btn btn-lg btn-white mx-auto mt-50 mb-40 load_more_button"  id="load_more_button">@lang('modules.front.loadMore')</button>
                                </div>
                            @endif
                        </div>

                   
                    
             
                 
                 