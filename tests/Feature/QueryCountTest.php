<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QueryCountTest extends TestCase
{
    use RefreshDatabase;

    private static int $sequence = 0;

    private function countQueries(callable $callback): int
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $callback();

        $count = count(DB::getQueryLog());
        DB::disableQueryLog();

        return $count;
    }

    private function makeOrder(int $customerId, int $merchantProfileId, ?Menu $menu = null): Order
    {
        self::$sequence++;

        $order = Order::create([
            'order_number' => 'ORD-N1-'.self::$sequence,
            'customer_id' => $customerId,
            'merchant_profile_id' => $merchantProfileId,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor',
            'total' => 25000,
            'status' => Order::STATUS_PENDING,
        ]);

        if ($menu) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'menu_name' => $menu->name,
                'unit_price' => 25000,
                'quantity' => 1,
                'subtotal' => 25000,
            ]);
        }

        return $order;
    }

    /**
     * Membandingkan jumlah query saat data sedikit vs banyak.
     * Jika jumlah query bertambah mengikuti jumlah baris, berarti terjadi N+1.
     */
    private function assertNoNPlusOne(int $few, int $many, string $label): void
    {
        $this->assertLessThanOrEqual(
            $few,
            $many,
            "{$label}: jumlah query bertambah dari {$few} menjadi {$many} — indikasi N+1."
        );
    }

    public function test_merchant_order_list_is_not_n_plus_one(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();
        $merchant = $profile->user;

        $this->makeOrder($customer->id, $profile->id, $menu);

        $few = $this->countQueries(fn () => $this->actingAs($merchant)
            ->getJson(route('merchant.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        for ($i = 0; $i < 9; $i++) {
            $this->makeOrder($customer->id, $profile->id, $menu);
        }

        $many = $this->countQueries(fn () => $this->actingAs($merchant)
            ->getJson(route('merchant.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Merchant order list');
    }

    public function test_customer_order_list_is_not_n_plus_one(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $this->makeOrder($customer->id, $profile->id, $menu);

        $few = $this->countQueries(fn () => $this->actingAs($customer)
            ->getJson(route('customer.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        for ($i = 0; $i < 9; $i++) {
            $this->makeOrder($customer->id, $profile->id, $menu);
        }

        $many = $this->countQueries(fn () => $this->actingAs($customer)
            ->getJson(route('customer.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Customer order list');
    }

    public function test_admin_order_list_is_not_n_plus_one(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $this->makeOrder($customer->id, $profile->id, $menu);

        $few = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        for ($i = 0; $i < 9; $i++) {
            $this->makeOrder($customer->id, $profile->id, $menu);
        }

        $many = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Admin order list');
    }

    public function test_admin_merchant_list_is_not_n_plus_one(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        MerchantProfile::factory()->count(1)->create();

        $few = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.merchants.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        MerchantProfile::factory()->count(9)->create();

        $many = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.merchants.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Admin merchant list');
    }

    public function test_admin_user_list_is_not_n_plus_one(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        MerchantProfile::factory()->count(1)->create();

        $few = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.users.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        MerchantProfile::factory()->count(9)->create();

        $many = $this->countQueries(fn () => $this->actingAs($admin)
            ->getJson(route('admin.users.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Admin user list');
    }

    public function test_admin_dashboard_is_not_n_plus_one(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $profile = MerchantProfile::factory()->create();
        $customer = User::factory()->customer()->create();

        $this->makeOrder($customer->id, $profile->id);

        $few = $this->countQueries(fn () => $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk());

        for ($i = 0; $i < 5; $i++) {
            $this->makeOrder($customer->id, $profile->id);
        }

        $many = $this->countQueries(fn () => $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Admin dashboard');
    }

    public function test_merchant_dashboard_is_not_n_plus_one(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();
        $merchant = $profile->user;

        $this->makeOrder($customer->id, $profile->id, $menu);

        $few = $this->countQueries(fn () => $this->actingAs($merchant)
            ->get(route('merchant.dashboard'))
            ->assertOk());

        for ($i = 0; $i < 5; $i++) {
            $this->makeOrder($customer->id, $profile->id, $menu);
        }

        $many = $this->countQueries(fn () => $this->actingAs($merchant)
            ->get(route('merchant.dashboard'))
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Merchant dashboard');
    }

    public function test_customer_dashboard_is_not_n_plus_one(): void
    {
        $profile = MerchantProfile::factory()->create();
        $customer = User::factory()->customer()->create();

        $this->makeOrder($customer->id, $profile->id);

        $few = $this->countQueries(fn () => $this->actingAs($customer)
            ->get(route('customer.dashboard'))
            ->assertOk());

        for ($i = 0; $i < 5; $i++) {
            $this->makeOrder($customer->id, $profile->id);
        }

        $many = $this->countQueries(fn () => $this->actingAs($customer)
            ->get(route('customer.dashboard'))
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Customer dashboard');
    }

    public function test_catering_detail_is_not_n_plus_one(): void
    {
        $profile = MerchantProfile::factory()->create();
        Menu::factory()->count(1)->create(['merchant_profile_id' => $profile->id]);

        $customer = User::factory()->customer()->create();

        $few = $this->countQueries(fn () => $this->actingAs($customer)
            ->get(route('customer.caterings.show', $profile))
            ->assertOk());

        Menu::factory()->count(9)->create(['merchant_profile_id' => $profile->id]);

        $many = $this->countQueries(fn () => $this->actingAs($customer)
            ->get(route('customer.caterings.show', $profile))
            ->assertOk());

        $this->assertNoNPlusOne($few, $many, 'Catering detail (menus)');
    }
}
