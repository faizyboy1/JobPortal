<?php

namespace App\Http\Requests\InterviewSchedule;

use App\Http\Requests\CoreRequest;

class StoreRequest extends CoreRequest
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
        if($this->interview_type == 'online'){
            $data= [
                'meeting_title' => 'required',
                "candidates.0"    => "required",
                "employees.0"      => "required",
                "scheduleDate"    => "required",
                "scheduleTime"    => "required",
                "end_date"    => "required",
                "end_time"    => "required",
            ];
        }else{
            $data = [
                "candidates.0"    => "required",
                "employees.0"      => "required",
                "scheduleDate"    => "required",
                "scheduleTime"    => "required",
            ];
        }
        
        return $data;
    }

    public function messages()
    {
        return [
            'employees.*' => 'Please select at-least one employee.',
            'candidates.*' => 'Please select at-least one candidate.'
        ];
    }
}
