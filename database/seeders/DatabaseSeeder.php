<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $merchantUser = User::create([
            'name' => 'Dapur Nusantara',
            'email' => 'merchant@example.com',
            'password' => 'password',
            'role' => User::ROLE_MERCHANT,
        ]);

        $profile = MerchantProfile::create([
            'user_id' => $merchantUser->id,
            'company_name' => 'Dapur Nusantara',
            'address' => 'Jl. Merdeka No. 10, Jakarta Selatan',
            'phone' => '081234567890',
            'food_type' => 'Nasi Kotak',
            'description' => 'Katering makanan kantor dengan menu nusantara.',
        ]);

        $menus = [
            ['Nasi Kotak Ayam Bakar', 'Nasi, ayam bakar, sayur, sambal', 25000],
            ['Nasi Kotak Rendang', 'Nasi, rendang sapi, sayur, sambal', 30000],
            ['Nasi Kotak Vegetarian', 'Nasi, tumis sayur, tempe, tahu', 22000],
            ['Paket Prasmanan', 'Prasmanan untuk 10 porsi', 350000],
        ];

        foreach ($menus as [$name, $description, $price]) {
            Menu::create([
                'merchant_profile_id' => $profile->id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'is_available' => true,
            ]);
        }

        $merchantUser2 = User::create([
            'name' => 'Katering Sehat',
            'email' => 'merchant2@example.com',
            'password' => 'password',
            'role' => User::ROLE_MERCHANT,
        ]);

        $profile2 = MerchantProfile::create([
            'user_id' => $merchantUser2->id,
            'company_name' => 'Katering Sehat',
            'address' => 'Jl. Sudirman No. 5, Jakarta Pusat',
            'phone' => '081298765432',
            'food_type' => 'Makanan Sehat',
            'description' => 'Katering sehat rendah minyak.',
        ]);

        Menu::create([
            'merchant_profile_id' => $profile2->id,
            'name' => 'Salad Bowl',
            'description' => 'Salad sayur dengan protein pilihan',
            'price' => 28000,
            'is_available' => true,
        ]);

        User::create([
            'name' => 'PT Kantor Makmur',
            'email' => 'customer@example.com',
            'password' => 'password',
            'role' => User::ROLE_CUSTOMER,
        ]);
    }
}
