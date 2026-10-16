<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class StoreMerchantProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'food_type' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'company_name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'phone.max' => 'Nomor telepon maksimal 30 karakter.',
            'food_type.max' => 'Jenis makanan maksimal 100 karakter.',
        ];
    }
}
