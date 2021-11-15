<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Company;
use App\Company_category;
use App\LinkedInSetting;
use App\CompanyPackage;
use App\JobLocation;
use App\ThemeSetting;
use App\Job;
use App\User;
use Carbon\Carbon;
use App\JobCategory;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;
class FrontCompanyController extends FrontBaseController
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

    public function allCompanies($slug=null){
        // if(isset($id)){
        //     dd($id);
        // }
        
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
        
        
        // $data['companies'] = Company::get(); 
        $this->category = Company_category::get();
        // $this->companies = Company::where('category_id', '1')->get();
        $this->companies = Company::get();
        $this->address = $this->companies->unique('address');

        // if(isset($id)){
        //     return view('front.job-openings', $this->data);
        // } 
        return view('front.companies', $this->data);
    }

    function moreCompanyData(Request $request){
        
        if($request->ajax()){

            $location = Company::all('address');
            foreach($location as $locations){
              foreach($locations as $locationn){

              }
            }
            $this->locations = Company::all('address');
            $this->categories = Company_category::all();
               $company = $this->data($request);
                $totalCurrentData = $request->totalCurrentData;
                $take = $this->perPage + $totalCurrentData;
                $this->allCompanies = Company::activeCompanies();

                $this->companies = $company->skip($totalCurrentData)->take($this->perPage);
                $this->hideButton = 'no';
                if($this->allCompanies->count() <= ($totalCurrentData+$this->perPage)){
                    $this->hideButton = 'yes';
                }
                $this->company_current_count = $totalCurrentData+$this->perPage;
                $this->companyCount = $this->allCompanies->count();
                $view = view('front.more_company_data', $this->data)->render();
                return Reply::dataOnly(['status' => 'success', 'view' => $view,'data' => $this->data]);
        }
    }

    function searchCompany(Request $request){
        $this->locations = Company::all('address');
        $this->categories = Company_category::all();
        $companies = $this->data($request);
        $this->companyCount = $companies->count();
        $this->companies =  $companies->take($this->perPage);
         $this->company_current_count = $this->perPage;
         $this->hideButton = 'no';
         if($companies->count() < ($this->perPage)){
             $this->hideButton = 'yes';
         }
        $view = view('front.more_company_data', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view,'data' => $this->data]);
    }

    function data($request){
        $companies = Company::where('status', 'active');

        
        if ($request->company !== null && $request->company != 'all' ) {
            $companies= $companies->where('company_name',$request->company);
        }

        if ($request->location !== null && $request->location != 'all' ) {
            $companies= $companies->where('address', $request->location);
        }

        if($request->company !== null && $request->company != 'all' && $request->location !== null && $request->location != 'all'){
            $companies=$companies->where([
                ['company_name',$request->company],
            ['address',$request->location]
            ]);
        }



        return $companies->get();
     }
    
}