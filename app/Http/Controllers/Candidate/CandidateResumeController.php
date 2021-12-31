<?php

namespace App\Http\Controllers\Candidate;

use App\AwardResume;
use App\CandidateResume;
use App\Certification;
use App\Helper\Reply;
use App\Country;
use App\Education;
use App\Http\Requests\Resume;
use App\LanguageResume;
use App\Skill;
use App\SkillsResume;
use App\User;
use App\WorkExperience;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Smalot\PdfParser\Parser;
use PDF;

class CandidateResumeController extends CandidateBaseController
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {
        $check = (CandidateResume::where('user_id', auth()->user()->id)->first()) ? true : false;
        if ($check && auth()->user()) {

            $this->candidateResume = CandidateResume::where('user_id', auth()->user()->id)->first();
            $this->educations = Education::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            $this->certifications = Certification::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            $this->awards = AwardResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            $this->languages = LanguageResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            $this->skills = SkillsResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            $this->experiences = WorkExperience::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
            // $this->countries = Country::all();

            return view('candidate.resume.index', $this->data);
        }
        if (!$check) {
            $this->countries = Country::all();
            return view('candidate.resume.create', $this->data);
        }

        return view('auth.login');
    }
    // Generate PDF
    public function createPDF()
    {
        // retreive all records from db

        $this->candidateResume = CandidateResume::where('user_id', auth()->user()->id)->first();
        $this->educations = Education::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->certifications = Certification::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->awards = AwardResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->languages = LanguageResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->skills = SkillsResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->experiences = WorkExperience::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        // $this->countries = Country::all();
        // dd($this->data);
        // return view('candidate.resume.index', $this->data);
        // share data to view
        view()->share('candidate', $this->data);
        $pdf = PDF::loadView('candidate.resume.pdf_View', $this->data);

        // download PDF file with download method
        return $pdf->download('resume.pdf');
    }
    public function store(Resume $request)
    {
        // Simple Profile
        $profile_info = new CandidateResume();
        if ($request->has('profile_picture')) {
            $imagepath = request('profile_picture')->store('profileResume', 'public');
            // $image = Image::make(public_path("storage/{$imagepath}"));
            // $image->save();
            // $imageArray = ['image' => $imagePath];
            $profile_info->profile_picture = $imagepath;
            return Reply::dataOnly(['ProfilePicturePath' => $imagepath, 'DbPath' => $profile_info->profile_picture]);
        }

        $profile_info->user_id = auth()->user()->id;
        $profile_info->first_name = $request->input('first_name');
        $profile_info->middle_name = $request->input('middle_name');
        $profile_info->last_name = $request->input('last_name');
        $profile_info->address = $request->input('address');
        $profile_info->city = $request->input('city');
        $profile_info->state = $request->input('state');
        // $profile_info->country_id = $request->input('country_id');
        $profile_info->country = $request->input("country_name");
        $profile_info->zip_code = $request->input('zip_code');
        $profile_info->country_code = $request->input('country_code');
        $profile_info->phone = $request->input('phone_number');
        $profile_info->email = $request->input('email');
        $profile_info->objective = $request->input('objective');
        $profile_info->save();
        $temp = auth()->user()->candidateResume->id;
        //Education fields 
        //Firstly we are converting all the different fields into a single array

        $edu_array_education = [];
        for ($i = 0; $i <= (count($request->degree_name) - 1); $i++) {
            $edu = [
                "degree_name" => $request->degree_name[$i],
                "passing_year" => $request->passing_year[$i],
                "institute" => $request->institute[$i]
            ];
            array_push($edu_array_education, $edu);
        }
        foreach ($edu_array_education as $edu) {
            $education = new Education();
            $education->candidate_resume_id = $temp;
            $education->degree = $edu['degree_name'];
            $education->year = $edu['passing_year'];
            $education->institute = $edu['institute'];
            $education->save();
        }


        //Certification fields 
        //Firstly we are converting all the different fields into a single array

        $certifications = [];
        for ($i = 0; $i <= (count($request->certification_name) - 1); $i++) {
            $certificate = ["certification_name" => $request->certification_name[$i], "certification_year" => $request->certification_year[$i], "certification_institute" => $request->certification_institute[$i]];
            array_push($certifications, $certificate);
        }
        foreach ($certifications as $certificate) {
            $certificates = new Certification();
            $certificates->candidate_resume_id = $temp;
            $certificates->certification_name = $certificate['certification_name'];
            $certificates->certification_year = $certificate['certification_year'];
            $certificates->certification_institute = $certificate['certification_institute'];
            $certificates->save();
        }


        //Awards fields 
        //Firstly we are converting all the different fields into a single array

        $awards = [];
        for ($i = 0; $i <= (count($request->award_name) - 1); $i++) {
            $award = ["award_name" => $request->award_name[$i], "award_year" => $request->award_year[$i], "award_institute" => $request->award_institute[$i]];
            array_push($awards, $award);
        }
        foreach ($awards as $award) {
            $awa = new AwardResume();
            $awa->candidate_resume_id = $temp;
            $awa->award_name = $award['award_name'];
            $awa->award_year = $award['award_year'];
            $awa->award_institute = $award['award_institute'];
            $awa->save();
        }


        //Languages fields 

        foreach ($request->language as $language) {

            $languages = new LanguageResume();
            $languages->candidate_resume_id = $temp;
            $languages->language = $language;
            $languages->save();
        }


        //Skills fields 

        foreach ($request->skills as $skill) {

            $skills = new SkillsResume();
            $skills->candidate_resume_id = $temp;
            $skills->skill = $skill;
            $skills->save();
        }
        //Work Experience fields 
        //Firstly we are converting all the different fields into a single array
        $work_experiences = [];
        for ($i = 0; $i <= (count($request->company_name) - 1); $i++) {

            $experience = [
                "company_name" => $request->company_name[$i],
                "start_date" => $request->start_date[$i],
                "end_date" => $request->end_date[$i],
                "present" => $request->present[$i],
                "job_title" => $request->job_title[$i],
                "job_description" => $request->job_description[$i]
            ];



            array_push($work_experiences, $experience);
        }

        foreach ($work_experiences as $work_experience) {

            $experiences = new WorkExperience();
            $experiences->candidate_resume_id = $temp;
            $experiences->company_name = $work_experience['company_name'];
            $experiences->start_date = $work_experience['start_date'];
            if ($work_experience["end_date"] == null || $work_experience["end_date"] == "null") {

                $experiences->end_date = "null";
            }
            if ($work_experience["end_date"] && $work_experience["end_date"] !== "null") {
                $experiences->present = $work_experience['end_date'];
            }

            if ($work_experience["present"] == null || $work_experience["present"] == "null") {

                $experiences->present = "null";
            }
            if ($work_experience["present"] == "on") {
                $experiences->present = "Present";
            }
            $experiences->job_title = $work_experience['job_title'];
            $experiences->job_description = $work_experience['job_description'];
            $experiences->save();
        }

        return Reply::redirect(route('candidate.resume.index'));
    }
    public function storeFile(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = $file->getClientOriginalName();

            // $file = $request->validate(
            //     ['file' => 'required|mimes:pdf',]
            // );
            // // use of pdf parser to read content from pdf 
            // $fileName = $file->getClientOriginalName();

            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($file->path());

            $content = $pdf->getText();
            // $content = explode("\n", str_replace(' ', '', $pdf->getText()));
            //Extract NAme 
            $content = explode("\n", $content);
            $this->name = $content[1];
            //Extract Email 

            $email_index = array_search("E-mail: ", $content);
            $this->email = $content[$email_index + 1];
            //Extract Address 

            $address_array = [];

            for ($i = 2; $i < $email_index; $i++) {
                array_push($address_array, $content[$i]);
            }
            $this->address = $address_array;
            //Extract Languages 

            $languages_index = array_search("LANGUAGES", $content);
            $languages_array = [];
            $skills_index = array_search("SKILLS", $content);
            $objective_index = array_search("OBJECTIVE", $content);
            $workExperience_index = array_search("WORK EXPERIENCE", $content);
            $certification_index = array_search("CERTIFICATION", $content);
            for ($i = $languages_index + 1; $i < $skills_index; $i++) {
                array_push($languages_array, $content[$i]);
            }
            $this->languages_array = $languages_array;
            $this->objective = $content[$objective_index + 1];
            //Extract WorkExperience 

            $workExperience_array = [];
            for ($i = $workExperience_index + 1; $i < $certification_index; $i++) {
                array_push($workExperience_array, $content[$i]);
            }
            $this->workExperience_array = $workExperience_array;
            //Extract Certificaations 

            $certifications = [];
            for ($i = $certification_index + 1; $i < (array_search("AWARDS", $content) ? array_search("AWARDS", $content) : (sizeof($content))); $i++) {
                array_push($certifications, $content[$i]);
            }
            $this->certifications = $certifications;
            return view('candidate.resume.create', $this->data);
            dd($this->data, $content);
            dd(array_search("E-mail: ", $content));
        }
    }
    public function show()
    {
    }
    public function edit($id)
    {
        $this->candidateResume = CandidateResume::where('user_id', auth()->user()->id)->first();
        $this->educations = Education::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->certifications = Certification::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->awards = AwardResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->languages = LanguageResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->skills = SkillsResume::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->experiences = WorkExperience::where('candidate_resume_id', auth()->user()->candidateResume->id)->get();
        $this->countries = Country::all();
        return view('candidate.resume.edit', $this->data);
    }
    public function update(Resume $request, $id)
    {

        $country_name = Country::find($request->input('country'));
        // Simple Profile
        $profile_info = CandidateResume::where('id', $id)->first();
        $destination_path = public_path("/storage/");
        if ($request->has('profile_picture')) {
            File::delete($destination_path . $profile_info->profile_picture);
            $imagepath = request('profile_picture')->store('profileResume', 'public');
            // $image = Image::make(public_path("storage/{$imagepath}"));
            // $image->save();
            // $imageArray = ['image' => $imagePath];
            $profile_info->profile_picture = $imagepath;
        }
        $profile_info->user_id = auth()->user()->id;
        $profile_info->first_name = $request->input('first_name');
        $profile_info->middle_name = $request->input('middle_name');
        $profile_info->last_name = $request->input('last_name');
        $profile_info->address = $request->input('address');
        $profile_info->city = $request->input('city');
        $profile_info->state = $request->input('state');
        $profile_info->country = $request->input("country_name");
        $profile_info->zip_code = $request->input('zip_code');
        $profile_info->country_code = $request->input('country_code');
        $profile_info->phone = $request->input('phone_number');
        $profile_info->email = $request->input('email');
        $profile_info->objective = $request->input('objective');
        // dd($profile_info);
        $profile_info->save();

        //Education fields 
        //Firstly we are converting all the different fields into a single array

        $edu_array_education = [];
        for ($i = 0; $i <= (count($request->degree_name) - 1); $i++) {
            $edu = [
                "degree_name" => $request->degree_name[$i],
                "passing_year" => $request->passing_year[$i],
                "institute" => $request->institute[$i]
            ];
            array_push($edu_array_education, $edu);
        }
        Education::where('candidate_resume_id', $id)->delete();
        foreach ($edu_array_education as $edu) {
            $education = new Education();
            $education->candidate_resume_id = auth()->user()->candidateResume->id;
            $education->degree = $edu['degree_name'];
            $education->year = $edu['passing_year'];
            $education->institute = $edu['institute'];
            $education->save();
        }

        //Certification fields 
        //Firstly we are converting all the different fields into a single array

        $certifications = [];
        for ($i = 0; $i <= (count($request->certification_name) - 1); $i++) {
            $certificate = ["certification_name" => $request->certification_name[$i], "certification_year" => $request->certification_year[$i], "certification_institute" => $request->certification_institute[$i]];
            array_push($certifications, $certificate);
        }
        $certificates = Certification::where('candidate_resume_id', $id)->delete();
        foreach ($certifications as $certificate) {
            $certificates = new Certification();
            $certificates->candidate_resume_id = auth()->user()->candidateResume->id;
            $certificates->certification_name = $certificate['certification_name'];
            $certificates->certification_year = $certificate['certification_year'];
            $certificates->certification_institute = $certificate['certification_institute'];
            $certificates->save();
        }


        //Awards fields 
        //Firstly we are converting all the different fields into a single array

        $awards = [];
        for ($i = 0; $i <= (count($request->award_name) - 1); $i++) {
            $award = ["award_name" => $request->award_name[$i], "award_year" => $request->award_year[$i], "award_institute" => $request->award_institute[$i]];
            array_push($awards, $award);
        }
        AwardResume::where('candidate_resume_id', $id)->delete();
        foreach ($awards as $award) {
            $awa = new AwardResume();
            $awa->candidate_resume_id = auth()->user()->candidateResume->id;
            $awa->award_name = $award['award_name'];
            $awa->award_year = $award['award_year'];
            $awa->award_institute = $award['award_institute'];
            $awa->save();
        }


        //Languages fields 

        $languages = LanguageResume::where('candidate_resume_id', $id)->delete();
        foreach ($request->language as $language) {

            $languages = new LanguageResume();
            $languages->candidate_resume_id = auth()->user()->candidateResume->id;
            $languages->language = $language;
            $languages->save();
        }
        // $languages = LanguageResume::where('candidate_resume_id', $id)->get();
        // $check = false;
        // if (count($languages) < count($request->language)) {
        //     $new_languages = new LanguageResume();
        //     // $new_field = (count($request->language)) - (count($languages));
        //     for ($i = 0; $i <= count($request->language) - 1; $i++) {
        //         for ($j = 0; $j <= count($languages) - 1; $j++) {
        //             if ($request->language[$i] == $languages[$j]) {
        //                 $check = true;
        //             }
        //         }
        //         if (!$check) {
        //             $new_languages->language = $request->language[$i];
        //             $new_languages->save();
        //         }
        //     }
        // }

        // for ($i = 0; $i <= count($languages) - 1; $i++) {
        //     $languages[$i]->language = $request->language[$i];
        //     $languages[$i]->save();
        // }


        //Skills fields 
        $skills = SkillsResume::where('candidate_resume_id', $id)->delete();
        foreach ($request->skills as $skill) {
            $skills = new SkillsResume();
            $skills->candidate_resume_id = auth()->user()->candidateResume->id;
            $skills->skill = $skill;
            $skills->save();
        }

        //Work Experience fields 
        //Firstly we are converting all the different fields into a single array
        $work_experiences = [];
        // dd($request->end_date);

        for ($i = 0; $i <= (count($request->company_name) - 1); $i++) {

            $experience = [
                "company_name" => $request->company_name[$i],
                "start_date" => $request->start_date[$i],
                "end_date" => $request->end_date[$i],
                "present" => $request->present[$i],
                "job_title" => $request->job_title[$i],
                "job_description" => $request->job_description[$i]
            ];


            array_push($work_experiences, $experience);
        }
        WorkExperience::where('candidate_resume_id', $id)->delete();
        foreach ($work_experiences as $value => $work_experience) {
            $experiences = new WorkExperience();
            $experiences->candidate_resume_id = auth()->user()->candidateResume->id;
            $experiences->company_name = $work_experience['company_name'];
            $experiences->start_date = $work_experience['start_date'];
            if ($work_experience["end_date"] == "null" || $work_experience["end_date"] == null) {

                $experiences->end_date = "null";
            }
            if ($work_experience["end_date"] !== "null") {
                $experiences->end_date = $work_experience['end_date'];
            }

            if ($work_experience["present"] == null || $work_experience["present"] == "null") {

                $experiences->present = "null";
            }
            if ($work_experience["present"] == "on") {
                $experiences->present = "Present";
            }
            $experiences->job_title = $work_experience['job_title'];
            $experiences->job_description = $work_experience['job_description'];
            $experiences->save();
        }


        return redirect()->route('candidate.resume.index');
    }
}
