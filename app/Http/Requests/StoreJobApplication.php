<?php

namespace App\Http\Requests;

use App\Job;
use App\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreJobApplication extends CoreRequest
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
            'email' => 'email|required',
            'phone' => 'required',
            'job_id' => 'required|exists:jobs,id'
        ];

        if ($requiredColumns['gender']) {
            $rules = Arr::add($rules, 'gender', 'required|in:male,female,others');
        }
        if ($requiredColumns['dob']) {
            $rules = Arr::add($rules, 'dob', 'required|date');
        }
        if ($requiredColumns['country']) {
            $rules = Arr::add($rules, 'country', 'required|integer|min:1');
            $rules = Arr::add($rules, 'state', 'required|integer|min:1');
            $rules = Arr::add($rules, 'city', 'required');
        }

        if(isset($sectionVisibility)){
            foreach ($sectionVisibility as $key => $section) {
                if ($section === 'yes') {
                    if ($key === 'profile_image') {
                        $rules = Arr::add($rules, 'photo', 'required|mimes:jpeg,jpg,png');
                    }
                    if ($key === 'resume') {
                        $rules = Arr::add($rules, 'resume', 'required|mimes:jpeg,jpg,png,doc,docx,rtf,xls,xlsx,pdf');
                    }
                }
            }
        }


        $answers = $this->get('answer');
        if(isset($answers) && !empty($this->get('answer')))
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
        ];
    }
}
