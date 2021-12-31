
    <div class="container bg-white card">
        <div class="row d-flex p-4">
            @if ($candidateResume->profile_picture)
            <div class="">
                {{-- <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80" class="rounded-circle" width="150px" height="150px"  alt="profilePic"> --}}
                <img src="/storage/{{ $candidateResume->profile_picture }}" class="rounded-circle" width="150px" height="150px"  alt="profilePic">
            </div>
            @endif
            <div style="margin-left: 95px" class="flex-grow-1">
                <div style="border-bottom-width: 4px!important" class="candidateName pb-3 border border-top-0 border-right-0 border-left-0 border-primary">
                    <h2 class="candidateName__name"> <span class="text-primary">{{ $candidateResume->first_name }}</span> <span>{{ $candidateResume->last_name }}</span> </h2>
                </div>
                <div class="mt-4  d-flex justify-content-between">
                    <p class="basicInformation__address">
                        <span>{{ $candidateResume->address }}</span><br>
                        <span>{{ $candidateResume->state }}</span>-<span>{{ $candidateResume->zip_code }}</span><br>
                        <span>{{ $candidateResume->country }}</span>
                    </p>
                    <div class="basicInformation__Eaddress">
                        <div class="d-flex">
                            <span class=" mr-4 font-weight-bold text-primary">
                                E-mail:  
                            </span>
                            <p>{{ $candidateResume->email }}</p>
                        </div>
                        <div class="d-flex" >
                            <span class=" mr-4 font-weight-bold text-primary">Phone:</span>
                            <span>{{ $candidateResume->country_code }} </span>
                            <p>{{ $candidateResume->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">LANGUAGES</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                @foreach ($languages as $language)
                     <p>{{ $language->language }}</p>
                @endforeach
            </div>
        </div>
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">SKILLS</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                @foreach ($skills as $skill )
                    
                <p>{{ $skill->skill }}</p>
                @endforeach
            </div>
        </div>
        @if ($candidateResume->objective)
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">OBJECTIVE</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                <p>{{ $candidateResume->objective }}</p>
            </div>
        </div>
        @endif
        <div class="row d-flex p-4">
            <div  class=" ">
                <p  style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">EDUCATION</p>
            </div>
            <div class="d-flex flex-column flex-grow-1 ">
                @foreach ($educations as $education )
                
                <div style="margin-left: 45px;color:black!important" class=" text-black">
                    <div class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $education->degree }}</h4>
                        <h4>{{ $education->year }}</h4>
                    </div>
                    <p>{{ $education->institute }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @if (!is_null($experiences[0]->company_name))
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">WORK EXPERIENCE</p>
            </div>
            <div class="flex-grow-1">
                @foreach ($experiences as $experience)
                
                <div style="margin-left: 45px;" >
                    <div style="color:black!important" class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $experience->company_name }}</h4>
                        <h4> <span>{{$experience->start_date  }}</span>/<span>{{ $experience->present ==="Present" ? $experience->present : $experience->end_date }}</span></h4>
                    </div>
                    <p>{{ $experience->job_title }}</p>
                    <p>{{ $experience->job_description }}</p>
                </div>
            @endforeach
            </div>
        </div>
        @endif
        @if (!is_null($certifications[0]->certification_name))
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">CERTIFICATION</p>
            </div>
            <div class="flex-grow-1">
                @foreach ( $certifications as $certification )
            <div style="margin-left: 45px;" >
                <div style="color:black!important"  class="d-flex justify-content-between font-weight-bold">
                    <h4>{{ $certification->certification_name }}</h4>
                    <h4>{{ $certification->certification_year }}</h4>
                </div>
                <p>{{ $certification->certification_institute }}</p>    
            </div>
            @endforeach
            </div>
        </div>
        @endif
        @if (!is_null($awards[0]->award_name))
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">AWARDS</p>
            </div>
            <div class="flex-grow-1">
                @foreach ($awards as $award )
                <div style="margin-left: 45px;" >
                    <div style="color:black!important"  class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $award->award_name }}</h4>
                        <h4>{{ $award->award_year }}</h4>
                    </div>
                    <p>{{ $award->award_institute }}</p>   
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    
<style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
</style>


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
    .list-group-item{
        background-color: #f6f7fb;
        margin: 5px;
        border-radius: 0 !important;
        border: 0;
        padding: 5px;
        padding-left: 30px;
    }

    .list-group-item p {
        font-size: 12px;
        padding-left: 20px;
    }

    .list-group-item .btn{
        font-size: 13px;
        display: inline-block;
        padding: 0 5px;
        color: var(--main-color);
    }
</style>