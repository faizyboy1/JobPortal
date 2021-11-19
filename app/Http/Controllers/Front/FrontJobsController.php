<?php

namespace App\Http\Controllers\Front;

use App\ApplicationSetting;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\FrontJobApplication;
use App\CandidateInterviewTimeSlot;
use App\Job;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\JobCategory;
use App\JobLocation;
use App\LinkedInSetting;
use App\Notifications\NewJobApplication;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use App\Company;
use App\ApplicationStatus;
use App\CompanyPackage;
use App\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceivedApplication;
use App\ThemeSetting;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class FrontJobsController extends FrontBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('modules.front.jobOpenings');
        $this->perPage = 6;

        $linkedinSetting = LinkedInSetting::where('status', 'enable')->first();
        /*dd($linkedinSetting);*/
        if ($linkedinSetting) {
            Config::set('services.linkedin.client_id', $linkedinSetting->client_id);
            Config::set('services.linkedin.client_secret', $linkedinSetting->client_secret);
            Config::set('services.linkedin.redirect', $linkedinSetting->callback_url);
        }
    }

    public function jobOpenings($slug=null)
    {
        $company = Company::withoutGlobalScope('company');
        if(!is_null($slug)) {
            $company = $company->where('career_page_link', $slug)->first();
            if(module_enabled('Subdomain'))
            {
                $company = Company::where('sub_domain', request()->getHost())->first();
            }
        } else {
            $company = $this->global;
            if(module_enabled('Subdomain'))
            {
                $company = Company::where('sub_domain', request()->getHost())->first();
            }
        }
        abort_if(is_null($company),404);

        $activePackage = CompanyPackage::with('package')->where('company_id', $company->id)
            ->where('status', 'active')
            // ->where(function($query){
            //     $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
            //     $query->orWhereNull('end_date');
            // })
            ->first();

        if (!$activePackage) {
            return abort(404);
        }
        $this->jobs = Job::frontActiveJobs($company->id);
        $this->locations = JobLocation::withoutGlobalScope('company')->where('company_id', $company->id)->get();
        $this->categories = JobCategory::withoutGlobalScope('company')->where('company_id', $company->id)->get();

        $this->company = $this->global = $company;
        $this->companyName = $this->global->company_name;
        $this->frontTheme = ThemeSetting::where('company_id', $this->company->id)->first();
        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));
        
        $this->jobs = Job::frontActiveJobs($company->id)->take($this->perPage);
        $this->jobCount = Job::frontActiveJobs($company->id)->count();

        $this->locations = JobLocation::all();
        $this->categories = JobCategory::all();
        $careerPackage = $this->company->package;
        if(is_null($activePackage) || is_null($activePackage->package) || $activePackage->package->career_website == 0){
            return redirect("/");
        }

        return view('front.job-openings', $this->data);
    }

    public function job_companies($id='' ,$slug=null)
    {
        
        $company = Company::withoutGlobalScope('company');
        if(!is_null($slug)) {
            $company = $company->where('career_page_link', $slug)->first();
            if(module_enabled('Subdomain'))
            {
                $company = Company::where('sub_domain', request()->getHost())->first();
            }
        } else {
            $company = $this->global;
            if(module_enabled('Subdomain'))
            {
                $company = Company::where('sub_domain', request()->getHost())->first();
            }
            
        }
        abort_if(is_null($company),404);
        
        
        $activePackage = CompanyPackage::with('package')->where('company_id', $company->id)
            ->where('status', 'active')
            ->where(function($query){
                $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
                $query->orWhereNull('end_date');
            })->first();

        if (!$activePackage) {
            return abort(404);
        }

        $this->jobs = Job::companyJobs($id);

        $this->locations = JobLocation::withoutGlobalScope('company')->where('company_id', $id)->get();
        $this->categories = JobCategory::withoutGlobalScope('company')->where('company_id', $id)->get();

        $this->company = $this->global = $company;
        $this->companyName = $this->global->company_name;
        $this->frontTheme = ThemeSetting::where('company_id', $this->company->id)->first();
        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));
        
        $this->jobs = Job::companyJobs($id)->take($this->perPage);
        $this->jobCount = Job::companyJobs($id)->count();
        // dd($this->jobs[0]->category);
        
        $this->locations = JobLocation::all();
        $this->categories = JobCategory::all();
        $careerPackage = $this->company->package;
        if(is_null($activePackage) || is_null($activePackage->package) || $activePackage->package->career_website == 0){
            return redirect("/");
        }

        return view('front.job-openings', $this->data);
    }

    function moreData(Request $request){
        
        if($request->ajax()){
            $this->locations = JobLocation::all();
            $this->categories = JobCategory::all();
               $job = $this->data($request);
                $totalCurrentData = $request->totalCurrentData;
                $take = $this->perPage + $totalCurrentData;
                $this->allJobs = Job::activeJobs();

                $this->jobs = $job->skip($totalCurrentData)->take($this->perPage);
                $this->hideButton = 'no';
                if($this->allJobs->count() < ($totalCurrentData+$this->perPage)){
                    $this->hideButton = 'yes';
                }
                $this->job_current_count = $totalCurrentData+$this->perPage;
                $this->jobCount = $this->allJobs->count();
                $view = view('front.more_data', $this->data)->render();
                return Reply::dataOnly(['status' => 'success', 'view' => $view,'data' => $this->data]);
        }
    }
    public function jobOpeningSubDomain()
    {

        $company = Company::where('sub_domain', request()->getHost())->first();

        abort_if(is_null($company),404);

        $activePackage = CompanyPackage::with('package')->where('company_id', $company->id)
            ->where('status', 'active')
            ->where(function($query){
                $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
                $query->orWhereNull('end_date');
            })->first();

        if (!$activePackage) {
            return abort(404);
        }

        $this->jobs = Job::frontActiveJobs($company->id);
        $this->locations = JobLocation::withoutGlobalScope('company')->where('company_id', $company->id)->get();
        $this->categories = JobCategory::withoutGlobalScope('company')->where('company_id', $company->id)->get();

        $this->company = $this->global = $company;
        $this->companyName = $this->global->company_name;
        $this->frontTheme = ThemeSetting::where('company_id', $this->company->id)->first();
        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));

        $careerPackage = $this->company->package;
        if(is_null($activePackage) || is_null($activePackage->package) || $activePackage->package->career_website == 0){
            return redirect("/");
        }

        return view('front.job-openings', $this->data);
    }

    public function jobDetailWithCompany($companySlug, $slug)
    {
        $company = Company::select('id', 'career_page_link')->where('career_page_link', $companySlug)->first();

        return $this->jobDetail($slug, $company);
    }

    public function jobDetail($slug)
    {
        if(module_enabled('Subdomain')){
            $company = Company::select('id', 'sub_domain')->where('sub_domain', $_SERVER['HTTP_HOST'])->first();
            Session::put('companyId', $company->id);
        }

        $this->job = Job::where('slug', $slug)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active');

        if(module_enabled('Subdomain')){
            $this->job->where('company_id', $company->id);
        }

        $this->job=$this->job->firstOrFail();

        $this->linkedinGlobal = LinkedInSetting::first();
        Session::put('slug', $slug);

        $this->company = $this->global = $this->job->company;

        if(!module_enabled('Subdomain')){
            Session::put('companyId', $this->job->company->id);
        }

        $activePackage = CompanyPackage::where('company_id', $this->company->id)
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active')
            ->first();

        abort_if(!$activePackage,404);

        $this->companyName = $this->global->company_name;

        $this->frontTheme = ThemeSetting::where('company_id', $this->company->id)->first();
        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));

        $this->pageTitle = $this->job->title . ' - ' . $this->companyName;
        $this->metaTitle = isset($this->job->meta_details['title'])?$this->job->meta_details['title']:'';
        $this->metaDescription = isset($this->job->meta_details)?$this->job->meta_details['description']:'';
        $this->metaImage = $this->job->company->logo_url;
        $this->pageUrl = request()->url();

        return view('front.job-detail', $this->data);
    }

    // public function job_companies($id='' ,$slug='')
    // {
    //     if(module_enabled('Subdomain')){
    //         $company = Company::select('id', 'sub_domain')->where('sub_domain', $_SERVER['HTTP_HOST'])->first();
    //         Session::put('companyId', $company->id);
    //     }

    //     if($slug!='')
    //     {
    //         $this->job = Job::where('slug', $slug)
    //         ->whereDate('start_date', '<=', Carbon::now())
    //         ->whereDate('end_date', '>=', Carbon::now())
    //         ->where('status', 'active');
    //         // dd($this->data['job'],$id);
    //         // dd(1);
    //     }
    //     if($id!='')
    //     {
    //         $this->job = Job::where('company_id', $id)
    //         ->whereDate('start_date', '<=', Carbon::now())
    //         ->whereDate('end_date', '>=', Carbon::now())
    //         ->where('status', 'active');
    //         //  dd($this->data['job'],$id);
    //     }
        
    //     if(module_enabled('Subdomain')){
    //         $this->job->where('company_id', $company->id);
    //     }
        
    //     $this->job=$this->job->firstOrFail();
    //     dd($this->job);

    //     $this->linkedinGlobal = LinkedInSetting::first();
    //     Session::put('slug', $slug);

    //     $this->company = $this->global = $this->job->company;

    //     if(!module_enabled('Subdomain')){
    //         Session::put('companyId', $this->job->company->id);
    //     }

    //     $activePackage = CompanyPackage::where('company_id', $this->company->id)
    //         ->whereDate('end_date', '>=', Carbon::now())
    //         ->where('status', 'active')
    //         ->first();

    //     abort_if(!$activePackage,404);

    //     $this->companyName = $this->global->company_name;

    //     $this->frontTheme = ThemeSetting::where('company_id', $this->company->id)->first();
    //     App::setLocale($this->global->locale);
    //     Carbon::setLocale($this->global->locale);
    //     setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));

    //     $this->pageTitle = $this->job->title . ' - ' . $this->companyName;
    //     $this->metaTitle = isset($this->job->meta_details['title'])?$this->job->meta_details['title']:'';
    //     $this->metaDescription = isset($this->job->meta_details)?$this->job->meta_details['description']:'';
    //     $this->metaImage = $this->job->company->logo_url;
    //     $this->pageUrl = request()->url();

    //     return view('front.job-detail', $this->data);
    // }

    public function callback($provider, Request $request)
    {
        if ($request->error) {
            $this->errorCode = $request->error;
            $this->error = $request->error_description;
            return view('errors.linkedin', $this->data);
        }
        $this->user = Socialite::driver($provider)->stateless()->user();
        // dd($this->user);
        $this->slug = Session::get('slug');
        $this->companyId = Session::get('companyId');

        Session::put('accessToken', $this->user->token);
        Session::put('expiresIn', $this->user->expiresIn);

        $company = Company::whereId($this->companyId)->first();
        if(module_enabled('Subdomain')) {
            $companySubdomain = $company->sub_domain;
            $url = $request->getScheme().'://'.$companySubdomain.route('jobs.jobApply', $this->slug, false);
            return redirect()->to($url);
        }
        return redirect()->route('jobs.jobApply', ['companySlug' => $company->career_page_link, 'slug' => $this->slug]);

    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function jobApplyWithCompany($companySlug, $slug)
    {
        $companyId = Company::select('id', 'career_page_link')->where('career_page_link', $companySlug)->first()->id;

        return $this->jobApply($slug, $companyId);
    }

    public function jobApply($slug, $companyId=null)
    {
        if(module_enabled('Subdomain')) {
            $company = Company::select('id', 'sub_domain')->where('sub_domain', $_SERVER['HTTP_HOST'])->first();
        }

        $this->job = Job::where('slug', $slug)
            ->where(DB::raw('DATE(start_date)'), '<=', DB::raw('CURDATE()'))
            ->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));

        if(module_enabled('Subdomain')){
            $this->job->where('company_id', $company->id);
        }
        $this->job =    $this->job->firstOrFail();
        $this->accessToken = Session::get('accessToken');
        $this->user = [];
        if ($this->accessToken) {
            $this->user = Socialite::driver('linkedin')->userFromToken($this->accessToken);
        }
        $this->job = Job::with('company')->where('slug', $slug)->first();
        $this->company = $this->global = $this->job->company;
         
        // Convert time into slots
        $start_time=explode(":",$this->job->start_time_slot);
        $end_time=explode(":",$this->job->end_time_slot);
        $start_time_A=(int)$start_time[0];
        $start_time_B=(int)$start_time[1];

        $end_time_A=(int)$end_time[0];
        $end_time_B=(int)$end_time[1];

        $slots=[];
        for($i=0;$i<=$end_time_A-$start_time_A;$i++){
            if($i == $end_time_A-$start_time_A){
                continue;
            }
            $slots[$i]=$start_time_A+$i ." to ".($start_time_A+1+$i);
        }
        // if($start_time_A > $end_time_A){
        //     for($i=$start_time_A;$i<=$end_time_A;$i++){
        //         $slots=$i." to ".($i+1);
        //     }
        // }

        // if($end_time_A < $start_time_A){
        //     for($i=$end_time_A;$i<=$start_time_A;$i--){
        //         $slots=$i." to ".($i-1);
        //     }

        // }
        $this->slots1=$slots;
        
        



        // $activePackage = CompanyPackage::where('company_id', $this->company->id)
        //     ->where('status', 'active')
        //     ->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'))
        //     ->first();

        // if (!$activePackage) {
        //     return abort(404);
        // }
        $this->jobQuestion = $this->job->questions;

        $this->companyName = $this->global->company_name;
        $this->frontTheme = ThemeSetting::where('company_id', $this->job->company_id)->first();
        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale.'_'.strtoupper($this->global->locale));
        $this->applicationSetting = ApplicationSetting::where('company_id', $this->job->company->id)->first();
        $this->pageTitle = $this->job->title . ' - ' . $this->companyName;
        
        return view('front.job-apply', $this->data);
    }

    public function saveApplication(FrontJobApplication $request)
    {
        $job = Job::findOrFail($request->job_id);
        // $activePackage = CompanyPackage::where('company_id', $job->company_id)
        //     ->where('status', 'active')
        //     ->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'))
        //     ->first();
        
        // if (!$activePackage) {
        //     return abort(404);
        // }
            
        $applicationStatus = ApplicationStatus::where('company_id', $job->company_id)->firstOrFail();
       
        $jobApplication = new JobApplication();
        $candidateInterviewTimeSlot = new CandidateInterviewTimeSlot();
        $jobApplication->full_name = $request->full_name;
        $jobApplication->job_id = $request->job_id;
        $jobApplication->company_id = $job->company_id;
        $jobApplication->status_id = $applicationStatus->id;
        $jobApplication->email = $request->email;
        $jobApplication->phone = $request->phone;
        $jobApplication->candidate_interview_slot = $request->interviewTimeSlot;
        
        if ($request->has('gender')) {
            $jobApplication->gender = $request->gender;
        }
        if ($request->has('dob')) {
            $jobApplication->dob = $request->dob;
        }
        if ($request->has('country')) {
            $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
            $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];

            $jobApplication->country = $this->getName($countriesArray, $request->country);
            $jobApplication->state = $this->getName($statesArray, $request->state);
            $jobApplication->city = $request->city;
        }
        $candidateInterviewTimeSlot->time_slots = $request->interview_time_slot;
        $candidateInterviewTimeSlot->job_application_id = $request->job_id;

        $jobApplication->cover_letter = $request->cover_letter;
        $jobApplication->column_priority = 0;

        if ($request->hasFile('photo')) {
            $jobApplication->photo = Files::upload($request->photo,'candidate-photos');
        }
        $jobApplication->save();

        if ($request->hasFile('resume')) {
            $hashname = Files::upload($request->resume, 'documents/'.$jobApplication->id, null, null, false);
            $jobApplication->documents()->create([
                'company_id' => $job->company_id,
                'name' => 'Resume',
                'hashname' => $hashname
            ]);
        }

        $users = User::frontAllAdmins($job->company_id);
        $linkedin = false;
        if ($request->linkedinPhoto) {
            $contents = file_get_contents($request->linkedinPhoto);
            $getfilename =  str_replace(' ', '_', $request->full_name);
            $filename = $jobApplication->id.$getfilename.'.png';
            Storage::put('candidate-photos/'.$filename, $contents);
            $jobApplication = JobApplication::find($jobApplication->id);
            $jobApplication->photo = $filename;
            $jobApplication->save();
        }

        if($request->has('apply_type')){
            $linkedin = true;
        }

        if (!empty($request->answer)) {
            foreach ($request->answer as $key => $value) {
                $answer = new JobApplicationAnswer();
                $answer->job_application_id = $jobApplication->id;
                $answer->job_id = $request->job_id;
                $answer->question_id = $key;
                $answer->company_id = $job->company_id;
                $answer->answer = $value;
                $answer->save();
            }
        }
        
        // Notification::send($users, new NewJobApplication($jobApplication, $linkedin));
        
        Mail::send(new ReceivedApplication($jobApplication));

        return Reply::dataOnly(['status' => 'success', 'msg' => __('modules.front.applySuccessMsg')]);
    }

    public function fetchCountryState(Request $request)
    {
        $responseArr = [];

        $response = [
            "status" => "success", 
            "tp" => 1,
            "msg" => "Countries fetched successfully."
        ];

        switch ($request->type) {
            case 'getCountries':
                $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];

                foreach ($countriesArray as $country) {
                    $responseArr = Arr::add($responseArr, $country['id'], $country['name']);
                }
            break;
            case 'getStates':
                $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];
                $countryId = $request->countryId;

                $filteredStates = array_filter($statesArray, function ($value) use ($countryId) {
                    return $value['country_id'] == $countryId;
                });

                foreach ($filteredStates as $state) {
                    $responseArr = Arr::add($responseArr, $state['id'], $state['name']);
                }
            break;
        }
        $response = Arr::add($response, "result", $responseArr);                

        return response()->json($response);
    }

    public function getName($arr, $id)
    {
        $result = array_filter($arr, function ($value) use ($id) {
            return $value['id'] == $id;
        });
        return current($result)['name'];
    }
    
    function searchJob(Request $request){
        $this->locations = JobLocation::all();
        $this->categories = JobCategory::all();
        $jobs = $this->data($request);
        $this->jobCount = $jobs->count();
        $this->jobs =  $jobs->take($this->perPage);
         $this->job_current_count = $this->perPage;
         $this->hideButton = 'no';
         if($jobs->count() < ($this->perPage)){
             $this->hideButton = 'yes';
         }
        $view = view('front.more_data', $this->data)->render();
         return Reply::dataOnly(['status' => 'success', 'view' => $view,'data' => $this->data]);
     }

     function data($request){
        $jobs = Job::where('status', 'active')
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'));

        if ($request->category !== null && $request->category != 'all' ) {
            $jobs= $jobs->where('category_id',$request->category);
        }

        if ($request->location_id !== null && $request->location_id != 'all' ) {
            $jobs= $jobs->where('location_id', $request->location_id);
        }

        return $jobs->get();
     }
    
}
