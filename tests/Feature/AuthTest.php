<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_customer(): void
    {
        $response = $this->post('/register', [
            'name' => 'PT Kantor',
            'email' => 'kantor@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'customer',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'kantor@example.com',
            'role' => 'customer',
        ]);
        $this->assertAuthenticated();
    }

    public function test_user_can_register_as_merchant(): void
    {
        $response = $this->post('/register', [
            'name' => 'Dapur ABC',
            'email' => 'dapur@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'merchant',
        ]);

        $response->assertRedirect(route('merchant.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'dapur@example.com',
            'role' => 'merchant',
        ]);
    }

    public function test_registration_rejects_invalid_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'hacker@example.com']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->customer()->create([
            'email' => 'kantor@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'kantor@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->customer()->create([
            'email' => 'kantor@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'kantor@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_protected_pages(): void
    {
        $this->get(route('customer.dashboard'))->assertRedirect('/login');
        $this->get(route('merchant.dashboard'))->assertRedirect('/login');
    }
}
