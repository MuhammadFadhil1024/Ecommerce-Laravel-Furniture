<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;


    public function test_product_screen_can_be_rendered()
    {
        $product = product::all();

        $response = $this->get(
            'dashboard/product',
            ['product' => $product]
        );

        $response->assertStatus(302);
    }

    public function test_product_create_screen_can_be_rendered()
    {
        $response = $this->get('dashboard/product/create');

        $response->assertStatus(302);
    }

    public function test_users_can_store_product_using_the_create_screen()
    {

        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->post('dashboard/product', [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'slug' => $product->slug
        ]);
        $response->assertRedirectToRoute('dashboard.product.index');
    }

    public function test_product_edit_screen_can_be_rendered()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->get(route('dashboard.product.edit', $product->id));

        $response->assertStatus(200);
    }

    public function test_users_can_update_product_using_the_edit_screen()
    {

        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->put(route('dashboard.product.update', $product->id), [
            'name' => 'product 1',
            'price' => $product->price,
            'description' => $product->description,
            'slug' => $product->slug
        ]);
        $response->assertRedirectToRoute('dashboard.product.index');
    }

    public function test_users_can_delete_product()
    {

        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->delete(route('dashboard.product.destroy', $product->id));
        $response->assertRedirectToRoute('dashboard.product.index');
    }
}
