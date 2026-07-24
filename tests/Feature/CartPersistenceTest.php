<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPersistenceTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_cart_is_persisted_across_logout_and_login(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $product = Product::first();

        // 1. User logs in & adds product to cart
        $this->actingAs($user)
            ->post(route('cart.store', $product->id), ['qty' => 2])
            ->assertSessionHas('cart');

        // 2. User logs out (session cleared)
        $this->post(route('logout'));
        $this->assertGuest();

        // 3. User logs back in
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        // 4. Verify cart items are restored automatically
        $cartResponse = $this->get(route('cart.index'));
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($product->name);
    }
}
