<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|max:1024',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string',
            'country' => 'nullable|string|max:255',
        ];
    }
}
