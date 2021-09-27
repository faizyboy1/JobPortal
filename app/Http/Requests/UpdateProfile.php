<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class UpdateProfile extends CoreRequest
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
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$this->route('profile'),
            'image' => 'image|max:2048'
        ];

        if ($this->has('mobile')) {
            $rules = Arr::add($rules, 'mobile', 'required');
            $rules = Arr::add($rules, 'calling_code', 'required');
        }

        return $rules;
    }
}
