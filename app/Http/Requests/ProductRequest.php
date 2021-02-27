<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric', 
                'discount_percentage' => 'nullable|numeric',
                'description' => 'nullable|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric', 
                'discount_percentage' => 'nullable|numeric',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }
    }
}
