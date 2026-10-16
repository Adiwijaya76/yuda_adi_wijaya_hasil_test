<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_csrf_middleware_is_registered_in_web_group(): void
    {
        $kernel = app(Kernel::class);

        $middlewareGroups = (new \ReflectionClass($kernel))
            ->getProperty('middlewareGroups');

        $middlewareGroups->setAccessible(true);

        $web = $middlewareGroups->getValue($kernel)['web'] ?? [];

        $this->assertContains(
            PreventRequestForgery::class,
            $web
        );
    }

    public function test_login_form_includes_csrf_token(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('csrf-token', false);
        $response->assertSee('name="_token"', false);
    }

    public function test_register_rejects_admin_role_escalation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Attacker',
            'email' => 'attacker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'attacker@example.com']);
    }

    public function test_menu_name_is_escaped_against_xss(): void
    {
        $profile = MerchantProfile::factory()->create();
        $merchant = $profile->user;

        Menu::factory()->create([
            'merchant_profile_id' => $profile->id,
            'name' => '<script>alert("xss")</script>',
        ]);

        $response = $this->actingAs($merchant)
            ->getJson(route('merchant.menus.index'), ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertOk();
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $response->getContent());
    }

    public function test_menu_photo_rejects_non_image_file(): void
    {
        $profile = MerchantProfile::factory()->create();
        $merchant = $profile->user;

        Storage::fake('public');

        $response = $this->actingAs($merchant)->post(route('merchant.menus.store'), [
            'name' => 'Menu With Bad Photo',
            'price' => 20000,
            'photo' => UploadedFile::fake()->create('malware.php', 10, 'text/plain'),
        ]);

        $response->assertSessionHasErrors('photo');
        $this->assertDatabaseMissing('menus', ['name' => 'Menu With Bad Photo']);
    }

    public function test_customer_cannot_view_other_customer_order(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $owner = User::factory()->customer()->create();

        $order = Order::create([
            'order_number' => 'ORD-SEC-1',
            'customer_id' => $owner->id,
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

        $attacker = User::factory()->customer()->create();

        $this->actingAs($attacker)
            ->get(route('customer.orders.show', $order))
            ->assertForbidden();
    }

    public function test_merchant_cannot_delete_other_merchant_menu(): void
    {
        $otherProfile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $otherProfile->id]);

        $myProfile = MerchantProfile::factory()->create();

        $this->actingAs($myProfile->user)
            ->delete(route('merchant.menus.destroy', $menu))
            ->assertForbidden();

        $this->assertDatabaseHas('menus', ['id' => $menu->id]);
    }

    public function test_checkout_rejects_excessive_quantity(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'merchant_profile_id' => $profile->id,
            'delivery_date' => now()->addDay()->toDateString(),
            'delivery_address' => 'Jl. Kantor',
            'items' => [
                ['menu_id' => $menu->id, 'quantity' => 99999999],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.quantity');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_login_is_rate_limited(): void
    {
        $this->app->make('cache')->flush();

        User::factory()->customer()->create([
            'email' => 'kantor@example.com',
            'password' => 'password',
        ]);

        $lastStatus = null;

        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'kantor@example.com',
                'password' => 'wrong-password',
                '_token' => csrf_token(),
            ]);

            $lastStatus = $response->status();
        }

        $this->assertEquals(429, $lastStatus);
    }
}
