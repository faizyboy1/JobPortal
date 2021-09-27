<?php

namespace App\Http\Controllers\Front;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\FrontJobApplication;
use App\Job;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\JobCategory;
use App\JobLocation;
use App\JobQuestion;
use App\Notifications\JobOfferAccepted;
use App\Notifications\JobOfferRejected;
use App\Notifications\NewJobApplication;
use App\Onboard;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LinkedInSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class FrontJobOfferController extends FrontBaseController
{


    /**
     * FrontJobOfferController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.jobOffer';
        $this->companyName = $this->global->company_name;
    }

    public function index($offerCode)
    {
        // images format with icon
        $this->imageExt = [
            'png' => 'fa-file-image-o',
            'jpe' => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'jpg' => 'fa-file-image-o',
            'gif' => 'fa-file-image-o',
            'bmp' => 'fa-file-image-o',
            'ico' => 'fa-file-image-o',
            'tiff' => 'fa-file-image-o',
            'tif' => 'fa-file-image-o',
            'svg' => 'fa-file-image-o',
            'svgz' => 'fa-file-image-o',


        ];

        // adobe and ms office files format with icon
        $this->fileExt = [
            // adobe
            'pdf' => 'fa-file-pdf-o',
            'psd' => 'fa-file-image-o',
            'ai' => 'fa-file-o',
            'eps' => 'fa-file-o',
            'ps' => 'fa-file-o',

            // ms office
            'doc' => 'fa-file-text',
            'rtf' => 'fa-file-text',
            'xls' => 'fa-file-excel-o',
            'ppt' => 'fa-file-powerpoint-o',
            'docx' => 'fa-file-text',
            'xlsx' => 'fa-file-excel-o',
            'pptx' => 'fa-file-powerpoint-o',

            // open office
            'odt' => 'fa-file-text',
            'ods' => 'fa-file-text',
        ];

        $this->offer = Onboard::with(['applications','files','applications.job', 'department', 'designation'])->where('offer_code', $offerCode)->first();

        // Abort if requested offer not found.
        abort_if(is_null($this->offer), 404);

        $this->job = Job::with(['category','location', 'skills', 'company'])->where('id', $this->offer->applications->job->id)->first();
        return view('front.job-offer', $this->data);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function saveOffer(Request $request)
    {
        $offer = Onboard::where('offer_code', $request->code)->first();
        $jobApplication = JobApplication::findOrFail($offer->applications->id);

        if($request->type == 'accept'){
            $image     = $request->signature;  // your base64 encoded
            $image     = str_replace('data:image/png;base64,', '', $image);
            $image     = str_replace(' ', '+', $image);
            $imageName = str_random(32).'.'.'jpg';

            if (!\File::exists(public_path('user-uploads/offer/sign'))) {
                $result = \File::makeDirectory(public_path('user-uploads/offer/sign'), 0777, true);
            }

            \File::put(public_path(). '/user-uploads/offer/sign/' . $imageName, base64_decode($image));

            $offer->sign         =  $imageName;
            $offer->hired_status = 'accepted';
        }
        else{
            $offer->reject_reason = $request->reason;
            $offer->hired_status  = 'rejected';
        }

        $offer->save();

        // All admins data for send mail.
        $admins = User::allAdmins();

        if($request->type == 'accept'){
            // Send Email Or SMS to admin on accept.
            Notification::send($admins, new JobOfferAccepted($jobApplication));
        }else{
            // Send Email Or SMS to admin on reject.
            Notification::send($admins, new JobOfferRejected($jobApplication));
        }

        return Reply::success(__('messages.thankyouForYourResponse'));
    }
}
