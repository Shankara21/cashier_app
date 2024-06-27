<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama merk wajib diisi.',
            'name.string' => 'Nama merk harus berupa teks.',
            'name.max' => 'Nama merk tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama merk sudah ada, silakan pilih yang lain.',
            'category_id.required' => 'Kategori merk wajib diisi.',
            'category_id.exists' => 'Kategori merk tidak ditemukan.',
        ];
    }
}
