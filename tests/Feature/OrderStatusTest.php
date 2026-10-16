<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(): Order
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $order = Order::create([
            'order_number' => 'ORD-TEST-1',
            'customer_id' => $customer->id,
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor',
            'total' => 25000,
            'status' => Order::STATUS_PENDING,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'menu_name' => $menu->name,
            'unit_price' => $menu->price,
            'quantity' => 1,
            'subtotal' => $menu->price,
        ]);

        return $order;
    }

    public function test_merchant_can_confirm_pending_order(): void
    {
        $order = $this->createOrder();
        $merchant = $order->merchantProfile->user;

        $this->actingAs($merchant)
            ->patch(route('merchant.orders.status', $order), ['status' => Order::STATUS_CONFIRMED])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_CONFIRMED,
        ]);
    }

    public function test_merchant_cannot_jump_pending_to_delivered(): void
    {
        $order = $this->createOrder();
        $merchant = $order->merchantProfile->user;

        $this->actingAs($merchant)
            ->patch(route('merchant.orders.status', $order), ['status' => Order::STATUS_DELIVERED])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_PENDING,
        ]);
    }

    public function test_merchant_cannot_update_other_merchant_order(): void
    {
        $order = $this->createOrder();
        $otherMerchant = User::factory()->merchant()->create();

        $this->actingAs($otherMerchant)
            ->patch(route('merchant.orders.status', $order), ['status' => Order::STATUS_CONFIRMED])
            ->assertForbidden();
    }
}
