<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'code' => ['required', 'string', 'max:255', 'unique:products'],
            'brand' => ['required', 'string', 'max:255'],
            'buying_price' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'unit' => ['required', 'string', 'max:255'],
            'discount' => ['required', 'numeric'],
        ];
    }
}
