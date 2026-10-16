<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MerchantProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_merchant_can_create_menu(): void
    {
        $profile = MerchantProfile::factory()->create();
        $merchant = $profile->user;

        $response = $this->actingAs($merchant)->post(route('merchant.menus.store'), [
            'name' => 'Nasi Kotak Ayam',
            'description' => 'Nasi + ayam + sayur',
            'price' => 25000,
            'is_available' => 1,
        ]);

        $response->assertRedirect(route('merchant.menus.index'));
        $this->assertDatabaseHas('menus', [
            'merchant_profile_id' => $profile->id,
            'name' => 'Nasi Kotak Ayam',
        ]);
    }

    public function test_merchant_cannot_create_menu_with_invalid_price(): void
    {
        $profile = MerchantProfile::factory()->create();
        $merchant = $profile->user;

        $response = $this->actingAs($merchant)->post(route('merchant.menus.store'), [
            'name' => 'Menu Murah',
            'price' => 0,
        ]);

        $response->assertSessionHasErrors('price');
        $this->assertDatabaseMissing('menus', ['name' => 'Menu Murah']);
    }

    public function test_merchant_cannot_edit_other_merchant_menu(): void
    {
        $otherProfile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $otherProfile->id]);

        $myProfile = MerchantProfile::factory()->create();
        $merchant = $myProfile->user;

        $this->actingAs($merchant)
            ->put(route('merchant.menus.update', $menu), [
                'name' => 'Hacked Menu',
                'price' => 99999,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('menus', ['id' => $menu->id, 'name' => 'Hacked Menu']);
    }

    public function test_merchant_can_delete_own_menu(): void
    {
        $profile = MerchantProfile::factory()->create();
        $menu = Menu::factory()->create(['merchant_profile_id' => $profile->id]);

        $this->actingAs($profile->user)
            ->delete(route('merchant.menus.destroy', $menu))
            ->assertRedirect();

        $this->assertSoftDeleted('menus', ['id' => $menu->id]);
    }
}
