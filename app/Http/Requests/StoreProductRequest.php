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
            'brand_id' => ['required', 'exists:brands,id'],
            'variant_id' => ['nullable', 'exists:variants,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'code' => ['required', 'string', 'max:255', 'unique:products'],
            'discount' => ['required', 'numeric'],
            'buying_price' => ['required'],
            'selling_price' => ['required'],
            'qty' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Kategori wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
            'brand_id.required' => 'Merek wajib diisi.',
            'brand_id.exists' => 'Merek tidak valid.',
            'variant_id.exists' => 'Varian tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama produk sudah ada, silakan pilih yang lain.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.string' => 'Kode produk harus berupa teks.',
            'code.max' => 'Kode produk tidak boleh lebih dari 255 karakter.',
            'code.unique' => 'Kode produk sudah ada, silakan pilih yang lain.',
            'discount.required' => 'Diskon wajib diisi.',
            'discount.numeric' => 'Diskon harus berupa angka.',
            'buying_price.required' => 'Harga beli wajib diisi.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'qty.required' => 'Stok wajib diisi.',
            'qty.numeric' => 'Stok harus berupa angka.',
        ];
    }
}
