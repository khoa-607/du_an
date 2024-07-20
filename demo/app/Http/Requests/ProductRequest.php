<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_user' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
            'id_brand' => 'required|exists:brands,id',
            'status' => 'required|in:0,1',
            'sale' => 'nullable|numeric|min:0|max:100',
            'company' => 'nullable|string|max:255',
            'image' => 'nullable|array|max:3',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024', 
            'detail' => 'nullable|string'
        ];
    }
}
