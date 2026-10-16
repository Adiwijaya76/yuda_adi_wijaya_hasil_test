<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'merchant_profile_id' => ['required', 'integer', 'exists:merchant_profiles,id'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_address' => ['required', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*.menu_id' => ['required', 'integer', 'exists:menus,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'merchant_profile_id.required' => 'Merchant wajib dipilih.',
            'merchant_profile_id.exists' => 'Merchant tidak ditemukan.',
            'delivery_date.required' => 'Tanggal pengiriman wajib diisi.',
            'delivery_date.date' => 'Format tanggal pengiriman tidak valid.',
            'delivery_date.after_or_equal' => 'Tanggal pengiriman tidak boleh di masa lalu.',
            'delivery_address.required' => 'Alamat pengiriman wajib diisi.',
            'delivery_address.max' => 'Alamat pengiriman maksimal 500 karakter.',
            'items.required' => 'Pilih minimal satu menu.',
            'items.min' => 'Pilih minimal satu menu.',
            'items.max' => 'Maksimal 100 item per pesanan.',
            'items.*.menu_id.required' => 'Menu wajib dipilih.',
            'items.*.menu_id.exists' => 'Menu tidak ditemukan.',
            'items.*.quantity.required' => 'Jumlah porsi wajib diisi.',
            'items.*.quantity.integer' => 'Jumlah porsi harus bilangan bulat.',
            'items.*.quantity.min' => 'Jumlah porsi minimal 1.',
            'items.*.quantity.max' => 'Jumlah porsi maksimal 10.000.',
        ];
    }
}
