<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\type;

class Resume extends FormRequest
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
        $tempcompany_name = $this->get('company_name');
        $tempstart_date = $this->get('start_date');
        $tempend_date = $this->get('end_date');
        $tempjob_title = $this->get('job_title');
        $tempjob_description = $this->get('job_description');

        // dd(array_pop($tempcompany_name));
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country_code' => 'required|max:4',
            'phone_number' => 'required|max:10',
            'email' => 'required',
            'degree_name.*' => 'required',
            'passing_year.*' => 'required',
            'institute.*' => 'required',
            'language.*' => 'required',
            'skill.*' => 'required',
        ];
        if (
            array_pop($tempcompany_name) !== null ||
            array_pop($tempstart_date) !== null ||
            array_pop($tempend_date) !== null  ||
            array_pop($tempjob_title) !== null ||
            array_pop($tempjob_description) !== null
        ) {

            // dd("a gya");
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'country_code' => 'required|max:4',
                'phone_number' => 'required|max:10',
                'email' => 'required',
                'degree_name.*' => 'required',
                'passing_year.*' => 'required',
                'institute.*' => 'required',
                'language.*' => 'required',
                'skill.*' => 'required',
                'company_name.*' => 'required',
                'start_date.*' => 'required',
                'end_date.*' => 'required',
                'job_title.*' => 'required',
                'job_description.*' => 'required',
            ];
        }
        return $rules;
    }
}
