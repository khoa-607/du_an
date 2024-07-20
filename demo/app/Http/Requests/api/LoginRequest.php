<?php

namespace App\Http\Requests\api;

use App\Http\Requests\api\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email sai định dạng',
            'password.required' => 'Password không được để trống'
        ];
    }
}
