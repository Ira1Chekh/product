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
            'title' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1', 'max:9999999999'],
            'currency_id' => ['required', 'exists:currencies,id'],
        ];
    }
}
