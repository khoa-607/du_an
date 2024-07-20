<?php

namespace App\Http\Requests\api;

use App\Http\Requests\api\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute Không được để trống',
            'email.email' => ':attribute sai định dạng',
            'email.unique' => ':attribute đã tồn tại',
            'password.min' => ':attribute phải có ít nhất 8 ký tự',
        ];
    }
}
