<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnketaPost extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:30',
            'email' => 'required|email|max:255',
            'education' => 'required|in:Bachelor,Master,PhD|max:30',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->errorMessageGeneration()) {
                $validator->errors()->add('first_name', 'In field "first_name" contains the word "test".');
            }
        });
    }

    /**
     * @return bool
     */
    protected function errorMessageGeneration()
    {
        return (bool)(strpos($this->get('first_name'), 'test') !== false);
    }
}
