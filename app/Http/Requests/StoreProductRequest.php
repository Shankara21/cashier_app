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

    public function messages()
    {
        return [
            'category_id.required' => 'Kategori wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama produk sudah ada, silakan pilih yang lain.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.string' => 'Kode produk harus berupa teks.',
            'code.max' => 'Kode produk tidak boleh lebih dari 255 karakter.',
            'code.unique' => 'Kode produk sudah ada, silakan pilih yang lain.',
            'brand.required' => 'Merek wajib diisi.',
            'brand.string' => 'Merek harus berupa teks.',
            'brand.max' => 'Merek tidak boleh lebih dari 255 karakter.',
            'buying_price.required' => 'Harga beli wajib diisi.',
            'buying_price.numeric' => 'Harga beli harus berupa angka.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.numeric' => 'Harga jual harus berupa angka.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'unit.required' => 'Satuan wajib diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan tidak boleh lebih dari 255 karakter.',
            'discount.required' => 'Diskon wajib diisi.',
            'discount.numeric' => 'Diskon harus berupa angka.',
        ];
    }
}
