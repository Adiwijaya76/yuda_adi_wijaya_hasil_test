<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceAccessTest extends TestCase
{
    use RefreshDatabase;

    private function createOrderWithInvoice(): Invoice
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $order = Order::create([
            'order_number' => 'ORD-TEST-2',
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

        return Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => 'INV-TEST-1',
            'issued_at' => now()->toDateString(),
            'total' => 25000,
        ]);
    }

    public function test_related_customer_can_view_invoice(): void
    {
        $invoice = $this->createOrderWithInvoice();
        $customer = $invoice->order->customer;

        $this->actingAs($customer)
            ->get(route('invoices.show', $invoice))
            ->assertOk();
    }

    public function test_related_merchant_can_view_invoice(): void
    {
        $invoice = $this->createOrderWithInvoice();
        $merchant = $invoice->order->merchantProfile->user;

        $this->actingAs($merchant)
            ->get(route('invoices.show', $invoice))
            ->assertOk();
    }

    public function test_unrelated_user_cannot_view_invoice(): void
    {
        $invoice = $this->createOrderWithInvoice();
        $otherUser = User::factory()->customer()->create();

        $this->actingAs($otherUser)
            ->get(route('invoices.show', $invoice))
            ->assertForbidden();
    }

    public function test_admin_can_view_any_invoice(): void
    {
        $invoice = $this->createOrderWithInvoice();
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('invoices.show', $invoice))
            ->assertOk();
    }
}
