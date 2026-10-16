<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'is_available' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama menu wajib diisi.',
            'name.max' => 'Nama menu maksimal 255 karakter.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat jpg, jpeg, png, atau webp.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga harus lebih dari 0.',
        ];
    }
}
