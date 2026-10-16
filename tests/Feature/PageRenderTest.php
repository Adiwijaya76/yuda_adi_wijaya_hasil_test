<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk');
    }

    public function test_register_page_renders(): void
    {
        $this->get(route('register'))->assertOk()->assertSee('Daftar');
    }

    public function test_merchant_dashboard_renders(): void
    {
        $profile = MerchantProfile::factory()->create();

        $this->actingAs($profile->user)
            ->get(route('merchant.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Merchant');
    }

    public function test_customer_caterings_page_renders(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)
            ->get(route('customer.caterings.index'))
            ->assertOk()
            ->assertSee('Cari Katering');
    }

    public function test_admin_user_list_renders_datatable_assets(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee('code.jquery.com', false);
        $response->assertSee('jquery.dataTables.min.js', false);
        $response->assertSee('DataTable(', false);
    }

    public function test_invoice_page_renders_for_merchant(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $order = Order::create([
            'order_number' => 'ORD-RENDER-1',
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

        $invoice = $order->invoice()->create([
            'invoice_number' => 'INV-RENDER-1',
            'issued_at' => now()->toDateString(),
            'total' => 25000,
        ]);

        $this->actingAs($profile->user)
            ->get(route('invoices.show', $invoice))
            ->assertOk()
            ->assertSee('Total Tagihan');
    }
}
