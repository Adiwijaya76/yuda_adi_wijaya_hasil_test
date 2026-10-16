<?php

namespace Tests\Feature;

use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin');
    }

    public function test_admin_can_view_users(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Kelola Pengguna');
    }

    public function test_admin_can_view_orders(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Semua Pesanan');
    }

    public function test_admin_orders_datatable_returns_json(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->getJson(route('admin.orders.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonStructure(['data', 'draw', 'recordsTotal', 'recordsFiltered']);
    }

    public function test_admin_users_datatable_returns_json(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $merchant = MerchantProfile::factory()->create();

        $this->actingAs($admin)
            ->getJson(route('admin.users.index'), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertSee($merchant->user->email);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Petugas Baru',
            'email' => 'petugas@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'merchant',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'petugas@example.com',
            'role' => 'merchant',
        ]);
    }

    public function test_admin_create_form_renders(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.users.create'))
            ->assertOk()
            ->assertSee('Tambah Pengguna');
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $customer), [
            'name' => 'Nama Diubah',
            'email' => $customer->email,
            'role' => 'merchant',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Nama Diubah',
            'role' => 'merchant',
        ]);
    }

    public function test_admin_cannot_create_user_with_duplicate_email(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $existing = User::factory()->customer()->create();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Duplikat',
            'email' => $existing->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'customer',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $customer = User::factory()->customer()->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $customer))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $customer->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
