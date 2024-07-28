<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModalRequest extends FormRequest
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
            'total_modal' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'total_modal.required' => 'Total modal wajib diisi.',
            'total_modal.numeric' => 'Total modal harus berupa angka.',
        ];
    }
}
