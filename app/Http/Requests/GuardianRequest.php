<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardianRequest extends FormRequest
{
    use HasUserAccount;
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
            'guardian_id_number' => ['required',  Rule::unique('guardians')->ignore(request('id'))],
            'first_name' => 'required',
            // 'middle_name' => 'required',
            'last_name' => 'required',
            // 'ext_name' => 'required',
            'gender_id' => 'required',
        ];
        if(request()->has('id') && request()->has('username')){
            $rules = [
                'username' => 'required',
            ];
        }
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validUserAccount($validator);
        });
    }
}
