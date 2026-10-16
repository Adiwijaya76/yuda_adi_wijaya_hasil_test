<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_cannot_access_merchant_dashboard(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)
            ->get(route('merchant.dashboard'))
            ->assertForbidden();
    }

    public function test_merchant_cannot_access_customer_dashboard(): void
    {
        $merchant = User::factory()->merchant()->create();

        $this->actingAs($merchant)
            ->get(route('customer.dashboard'))
            ->assertForbidden();
    }
}
