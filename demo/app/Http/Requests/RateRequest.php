<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'rate' => 'required|integer|between:1,5',
            'blog_id' => 'required|exists:blogs,id',
        ];
    }
}
