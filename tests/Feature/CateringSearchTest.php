<?php

namespace Tests\Feature;

use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CateringSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_keyword_only_returns_matching_caterings(): void
    {
        $customer = User::factory()->customer()->create();
        MerchantProfile::factory()->create(['company_name' => 'Dapur Nusantara', 'food_type' => 'Nasi Kotak']);
        MerchantProfile::factory()->create(['company_name' => 'Katering Sehat', 'food_type' => 'Salad']);

        $this->actingAs($customer)
            ->get(route('customer.caterings.index', ['q' => 'Nusantara']))
            ->assertOk()
            ->assertSee('Dapur Nusantara')
            ->assertDontSee('Katering Sehat');
    }

    public function test_filter_by_food_type_only(): void
    {
        $customer = User::factory()->customer()->create();
        MerchantProfile::factory()->create(['company_name' => 'Dapur Nusantara', 'food_type' => 'Nasi Kotak']);
        MerchantProfile::factory()->create(['company_name' => 'Katering Sehat', 'food_type' => 'Salad']);

        $this->actingAs($customer)
            ->get(route('customer.caterings.index', ['food_type' => 'Salad']))
            ->assertOk()
            ->assertSee('Katering Sehat')
            ->assertDontSee('Dapur Nusantara');
    }

    public function test_filter_by_location_only(): void
    {
        $customer = User::factory()->customer()->create();
        MerchantProfile::factory()->create(['address' => 'Jl. Merdeka No. 10, Jakarta Selatan']);
        MerchantProfile::factory()->create(['address' => 'Jl. Sudirman No. 5, Bandung']);

        $this->actingAs($customer)
            ->get(route('customer.caterings.index', ['location' => 'Bandung']))
            ->assertOk()
            ->assertSee('Bandung')
            ->assertDontSee('Jakarta Selatan');
    }
}
