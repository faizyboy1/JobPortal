@extends('layouts.front')

@section('header-text')
<div class="text-center">
  @foreach($companies as $logo)
    {{-- @if(Auth::user()->company_id == $logo->id) --}}
    {{-- <img src="{{asset('user-uploads/company-logo/'.$logo->logo)}}" class="img-fluid mb-3" style="height: 60px; width : 180px;"> --}}
    {{-- @endif --}}
  @endforeach  
</div>

<p class="text-white mb-40">@lang('modules.front.companyText') </p> 
<div class="location-search d-flex rounded-pill bg-white ">
     
    <div class="align-items-center d-flex rounded-pill location height-50">
        <select class="myselect" name="loaction" id="location">
            <option value="all">@lang('modules.front.allLocation')</option>  
            @foreach($address as $addresses)
                @if($addresses->address!='')
                    <option value="{{ $addresses->address }}">{{ ucfirst($addresses->address) }}</option>
                @endif        
            @endforeach
        </select>
    </div> 
    
    <span class="space position-relative hidden-sm-down "></span>

    <div class="align-items-center d-flex rounded-pill designation height-50">
        <select class="myselect" name="category" id ="company">
            <option value="all">All Companies</option>  
            @foreach($companies as $company)
                 <option value="{{ $company->company_name }}">{{ ucfirst($company->company_name) }}</option>
            @endforeach
        </select>
    </div> 
    
    <div class="search-btn w-25 rounded-pill align-items-center ">
        <button type="button" name="search" class="btn btn-lg btn-dark height-48 mr-4 my-1 align-items-center d-flex rounded-pill justify-content-center"  id="search">SEARCH</button>
    </div>
</div>

@endsection

@section('content')



    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Working at TheThemeio
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->

    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Open positions
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <section class="section bg-gray py-60">
        <div class="container">
            <div id="jobList">

                @foreach($category as $data)
                     <header class="section-header">
                         <h2 class="mt-40">{{$data->company_name}}</h2>
                         <hr>
                         <hr>
                     </header>    
     
                     <div data-provide="shuffle" id="applicant-notes">
                         <div class="row gap-y">
     
                             @forelse($companies as $company)
                                @if($company->category_id == $data->id) 
                                     <div class="col-12 col-md-6 col-lg-4 portfolio-2" data-shuffle="item">
     
                                       {{-- <a href="{{ route('jobs.job-companies', [$jobs->slug]) }}" class="job-opening-card"> --}}
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
                                 @endif
                                 @empty
                                 <h4 id ="no-data" class="mx-auto mt-50 mb-40 card-title mb-0" >@lang('modules.front.noData') </h4>
                             @endforelse
                         </div>
                         <!-- <div class="row gap-y">
                             <button type="button" name="load_more_button" class="btn btn-lg btn-white mx-auto mt-50 mb-40 load_more_button"  id="load_more_button">@lang('modules.front.loadMore')</button>
                         </div> -->
                     </div> 
                     @endforeach 
            </div>

        </div>
    </section>

@endsection


@push('footer-script')
<script>

    var perPage = '{{ $perPage }}';
    totalCurrentData = perPage;
    var companyCount = '{{ $jobCount }}';
    
    if(companyCount > perPage)
    {
        $('#load_more_button').show();
    }
    else{
        $('#load_more_button').hide();
    }
    var totalCurrentCount = $(".job-list").length;

    //load more 
         $('body').on('click', '#load_more_button', function () {
            var location = $('#location').val();
            var company = $('#company').val();
            var token = '{{ csrf_token() }}';
            $('#load_more_button').html('<b>'+"@lang('app.loading')"+'...</b>');
            $.easyAjax({
                url:"{{ route('jobs.more-company-data') }}",
                type:'POST',
                data: {'_token':token, 'totalCurrentData':totalCurrentData,'location':location, 'company':company },
                success:function(response) {
                    $('#jobList').append(response.view);
                    totalCurrentData = response.data.company_current_count;
                    $('#load_more_button').blur();
                    $('#load_more_button').html('@lang('modules.front.loadMore')');
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'yes'){
                        $('.load_more_button').hide();
                    }
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'no') {
                        $('.load_more_button').show();
                    }
                }
            });
        });

        //search
        $('body').on('click', '#search', function () {
            var location = $('#location').val();
            var company = $('#company').val();
            var token = '{{ csrf_token() }}';
            
            console.log( {location,company} ); // Data returned

            $.easyAjax({
                url:"{{ route('jobs.search-company') }}",
                type:'POST',
                data: {'_token':token, location:location, company:company},
                success:function(response){
                    $('#jobList').html(response.view);
                    totalCurrentData = response.data.company_current_count;
                    $([document.documentElement, document.body]).animate({
                         scrollTop: $("#applicant-notes").offset().top
                    }, 2000);
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'yes'){
                        $('#load_more_button').hide();
                    }
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'no') {
                        $('#load_more_button').show();
                    }
                }
            });
        });
    </script>
    @endpush
