<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_checkout_and_invoice_is_generated(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create([
            'merchant_profile_id' => $profile->id,
            'price' => 25000,
        ]);

        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor No. 1',
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 2],
            ],
        ]);

        $order = Order::first();

        $this->assertNotNull($order);
        $response->assertRedirect(route('customer.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total' => 50000,
            'status' => Order::STATUS_PENDING,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'menu_name' => $menu->name,
            'unit_price' => 25000,
            'quantity' => 2,
            'subtotal' => 50000,
        ]);

        $this->assertDatabaseHas('invoices', [
            'order_id' => $order->id,
            'total' => 50000,
        ]);
    }

    public function test_checkout_rejects_unavailable_menu(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create([
            'merchant_profile_id' => $profile->id,
            'is_available' => false,
        ]);

        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor No. 1',
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 1],
            ],
        ]);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('invoices', 0);
    }

    public function test_checkout_rejects_past_delivery_date(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->subDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor No. 1',
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 1],
            ],
        ]);

        $response->assertSessionHasErrors('delivery_date');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_price_is_recalculated_by_server(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create([
            'merchant_profile_id' => $profile->id,
            'price' => 10000,
        ]);

        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor No. 1',
            // attacker sends a fake total field - must be ignored
            'total' => 1,
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 3],
            ],
        ]);

        $this->assertDatabaseHas('orders', ['total' => 30000]);
    }
}
