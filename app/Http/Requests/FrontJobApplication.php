<?php

namespace App\Http\Requests;

use App\ApplicationSetting;
use App\Job;
use App\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class FrontJobApplication extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $job = Job::where('id', $this->job_id)->first();
        $requiredColumns = $job->required_columns;
        $sectionVisibility = $job->section_visibility;

        $rules = [
            'full_name' => 'required',
            'interviewTimeSlot' => 'required',
            'email' => [
                'required',
                Rule::unique('job_applications')->where(function ($query) use ($job) {
                    return $query->where('job_id', $this->job_id)->where('company_id', $job->company_id);
                })
            ],
            'phone' => 'required',
        ];
        if ($sectionVisibility) {
            foreach ($sectionVisibility as $key => $section) {
                if ($section === 'yes') {
                    if ($key === 'profile_image') {
                        $rules = Arr::add($rules, 'photo', 'required|mimes:jpeg,jpg,png');
                    }
                    if ($key === 'resume') {
                        $rules = Arr::add($rules, 'resume', 'required|mimes:jpeg,jpg,png,doc,docx,rtf,xls,xlsx,pdf');
                    }
                    if ($key === 'terms_and_conditions') {
                        $rules = Arr::add($rules, 'term_agreement', 'required');
                    }
                }
            }
        }
            if (isset($requiredColumns['gender']) && $requiredColumns['gender']) {
                $rules = Arr::add($rules, 'gender', 'required|in:male,female,others');
            }

        if (isset($requiredColumns['dob']) && $requiredColumns['dob']) {
            $rules = Arr::add($rules, 'dob', 'required|date');
        }
        if (isset($requiredColumns['country']) && $requiredColumns['country']) {
            $rules = Arr::add($rules, 'country', 'required|integer|min:1');
            $rules = Arr::add($rules, 'state', 'required|integer|min:1');
            $rules = Arr::add($rules, 'city', 'required');
        }
        $this->get('answer');
        if(!empty($this->get('answer')))
        {
            foreach($this->get('answer') as $key => $value){

                $answer = Question::where('id', $key)->first();
                if($answer->required == 'yes')
                $rules["answer.{$key}"] = 'required';
            }
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'answer.*' => 'This field is required.',
            'dob.required' => 'Date of Birth field is required.',
            'country.min' => 'Please select country.',
            'state.min' => 'Please select state.',
            'city.required' => 'Please enter city.',
            'email.unique' => 'You have already applied for this job with this email. Try different one.'
        ];
    }
}
