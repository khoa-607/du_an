<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'national' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng nhập trường :attribute.',
            'integer' => 'Tuổi phải là số nguyên.',
            'min' => 'Tuổi phải lớn hơn hoặc bằng 18.',
            'max' => 'Độ dài tối đa là :max ký tự.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'age' => 'Tuổi',
            'national' => 'Quốc tịch',
            'position' => 'Vị trí',
            'salary' => 'Lương',
        ];
    }
}
