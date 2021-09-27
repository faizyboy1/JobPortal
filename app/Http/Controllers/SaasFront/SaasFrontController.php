<?php

namespace App\Http\Controllers\SaasFront;

use App\ClientFeedback;
use App\Company;
use App\FooterMenu;
use App\FooterSetting;
use App\FrontCmsHeader;
use App\FrontIconFeature;
use App\FrontImageFeature;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Controllers\Front\FrontJobsController;
use App\Http\Requests\ContactForm;
use App\Http\Requests\RegisterForm;
use App\LanguageSetting;
use App\Mail\ContactMail;
use App\Notifications\EmailVerification;
use App\Notifications\EmailVerificationSuccess;
use App\Notifications\NewCompanyRegister;
use App\Package;
use App\Role;
use App\ThemeSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SaasFrontController extends SaasFrontBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->defaultFrontDetail = FooterSetting::first();
        $this->pageTitle = 'app.register';
    }

    public function index()
    {
        if(module_enabled('Subdomain')){
            $company = Company::where('sub_domain', request()->getHost())->first();
            if($company){
                $job = new FrontJobsController();
                return  $job->jobOpenings();
            }
        }
        $imageFeaturesCount = FrontImageFeature::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();
        $iconFeaturesCount = FrontIconFeature::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();
        $feedbackCount = ClientFeedback::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();
        $footerMenuCount = FooterMenu::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();
        $footerSettingsCount = FooterSetting::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();

        $this->imageFeatures = FrontImageFeature::where('language_settings_id', $imageFeaturesCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->get();
        $this->iconFeatures = FrontIconFeature::where('language_settings_id', $iconFeaturesCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->get();
        $this->feedbacks = ClientFeedback::where('language_settings_id', $feedbackCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->get();
        $this->packages = Package::where('is_trial', 0)->where('status', 1)->where('is_private',0)->get();
        $this->frontDetail = FooterSetting::where('language_settings_id', $footerSettingsCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->first();
        $this->footerSettings = FooterMenu::where('language_settings_id', $footerMenuCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->get();

        $currentDate = Carbon::now()->format('Y-m-d');
        $this->featuredCompanies = Company::where('status', 'active')
            ->where(function ($query) use($currentDate) {
                $query->whereNull('featured_start_date')
                    ->orWhere(DB::raw('DATE(`featured_start_date`)'), '<=', $currentDate);
            })
            ->where(function ($query) use($currentDate) {
                    $query->whereNull('featured_end_date')
                        ->orWhere(DB::raw('DATE(`featured_end_date`)'), '>=', $currentDate);
                })
                ->where(function ($query) use($currentDate) {
                    $query->whereNull('licence_expire_on')
                        ->orWhere(DB::raw('DATE(`licence_expire_on`)'), '>=', $currentDate);
                })
            ->where('featured', 1)->get();
        return view('saas-front.index', $this->data);
    }

    public function submitContact(ContactForm $request) {
        $superAdmin = User::whereNull('company_id')->first();
        
        Mail::to($superAdmin->email)->send(new ContactMail($request));

        // Notification::send($superAdmin, new ContactMail(request));
        return Reply::dataOnly(['status' => 'success']);
    }

    public function companyRegister(RegisterForm $request) {

        $company = new Company();
        try {
            $company->company_name = $request->company_name;
            $company->career_page_link = str_slug($request->career_page_link, '-');
            $company->job_opening_text = 'Welcome!';
            $company->job_opening_title = 'We want people to thrive. We believe you do your best work when you feel your best.';
            $company->timezone = 'Asia/Kolkata';

            if (module_enabled('Subdomain')){
                $company->sub_domain = $request->sub_domain;
            }

            $company->save();

            $user = new User();
            $user->company_id = $company->id;
            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->email_verification_code = str_random(40);
            $user->status = 'inactive';
            $user->save();

            //assign admin role to default user
            $role = Role::where('company_id', $company->id)->first();
            $user->roles()->attach($role->id);

            $user->notify(new EmailVerification($user));

            $superAdmin = User::whereNull('company_id')->get();
            Notification::send($superAdmin, new NewCompanyRegister($company));
        } catch (\Swift_TransportException $e) {
            DB::rollback();
            return Reply::error('Please contact administrator to set SMTP details to add company', 'smtp_error');
        } catch (\Exception $e) {
            DB::rollback();
            return Reply::error('Some error occurred when inserting the data. Please try again or contact support');
        }
        return Reply::dataOnly(['status' => 'success']);

    }

    public function getEmailVerification($code)
    {

        $this->pageTitle = 'modules.saasFront.emailVerification';
        $this->setting = GlobalSetting::first();
        $this->headerData = FrontCmsHeader::first();
        $this->frontTheme = ThemeSetting::whereNull('company_id')->first();

        $user = User::where('email_verification_code', $code)->whereNotNull('email_verification_code')->first();

        if ($user) {
            $user->status = 'active';
            $user->email_verification_code = '';
            $user->save();

            $user->notify(new EmailVerificationSuccess($user));

            $this->messsage = __('messages.emailVerifySuccess');
            $this->class = 'success';
            return view('saas-front.email-verification', $this->data);


        } else {

            $this->messsage = __('messages.emailVerifyFail');
            $this->class = 'error';
            return view('saas-front.email-verification', $this->data);
        }

    }

    public function changeLanguage($code)
    {
        $language = LanguageSetting::where('language_code', $code)->first();

        if (!$language) {
            return Reply::error('invalid language code');
        }

        return response(Reply::success(__('messages.languageChangedSuccessfully')))->cookie('language_code', $code);
    }

    public function page($slug = null)
    {
        $this->footerMenu = FooterMenu::where('slug', $slug)->with('seo_details')->first();
        $this->footerSettings = FooterMenu::all();
        $this->frontDetail = FooterSetting::first();

        return view('saas-front.page', $this->data);
    }
}
