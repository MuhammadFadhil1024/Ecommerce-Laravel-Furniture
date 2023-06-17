<?php

namespace Tests\Feature;

use App\Models\product;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_get_product_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create(); // Create a product

        $data = product::all();

        $response = $this->get('api/v1/dashboard/product');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_succes_store_product_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        // $product = product::factory()->create();
        $data = [
            'name' => 'meja belajar',
            'price' => 5000000,
            'description' => 'lorem ipsum doler amet'
        ];

        $response = $this->post('api/v1/dashboard/product', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'description' => $data['description'],
                    'slug' => $response->json('data.slug')
                ]
            ]);
    }

    public function test_failed_store_product_from_api_because_validation_required_data()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        // $product = product::factory()->create();
        $data = [
            'name' => '',
            'price' => null,
            'description' => ''
        ];

        $response = $this->post('api/v1/dashboard/product', $data);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'error'])
            ->assertJson([
                'message' => 'failed insert product',
                'error' => [
                    'name' => ['The name field is required.'],
                    'price' => ['The price field is required.'],
                    'description' => ['The description field is required.']
                ],
            ]);
    }

    public function test_succes_access_edit_product_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->get('api/v1/dashboard/product/' . $product->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'message'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'name' => $response->json('data.name'),
                    'price' => $response->json('data.price'),
                    'description' => $response->json('data.description'),
                    'slug' => $response->json('data.slug')
                ]
            ]);
    }

    public function test_failed_edit_product_from_api_because_data_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->get('api/v1/dashboard/product/' . 0);

        $response->assertStatus(404)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'product not found',
            ]);
    }

    public function test_succes_update_product_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();
        $update_data = [
            'name' => 'meja belajar',
            'price' => 5000000,
            'description' => 'lorem ipsum doler amet'
        ];

        $response = $this->put('api/v1/dashboard/product/' . $product->id, $update_data);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'name' => $response->json('data.name'),
                    'price' => $response->json('data.price'),
                    'description' => $response->json('data.description'),
                    'slug' => $response->json('data.slug')
                ]
            ]);
    }

    public function test_failed_update_product_from_api_because_data_is_available()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();
        $data = [
            'name' => '',
            'price' => null,
            'description' => ''
        ];

        $response = $this->put('api/v1/dashboard/product/' . $product->id, $data);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'error'])
            ->assertJson([
                'message' => 'failed update product',
                'error' => [
                    'name' => ['The name field is required.'],
                    'price' => ['The price field is required.'],
                    'description' => ['The description field is required.']
                ],
            ]);
    }

    public function test_failed_update_product_from_api_because_validation_required_data()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();
        $update_data = [
            'name' => $product->name,
            'price' => 5000000,
            'description' => 'lorem ipsum doler amet'
        ];

        $response = $this->put('api/v1/dashboard/product/' . $product->id, $update_data);

        $response->assertStatus(422)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'product is available',
            ]);
    }

    public function test_failed_update_product_from_api_because_data_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();
        $update_data = [
            'name' => $product->name,
            'price' => 5000000,
            'description' => 'lorem ipsum doler amet'
        ];

        $response = $this->put('api/v1/dashboard/product/' . 0, $update_data);

        $response->assertStatus(404)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'product not found',
            ]);
    }

    public function test_succes_delete_product_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->delete('api/v1/dashboard/product/' . $product->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'success',
            ]);
    }

    public function test_failed_delete_product_from_api_because_data_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $product = product::factory()->create();

        $response = $this->delete('api/v1/dashboard/product/' . 0);

        $response->assertStatus(401)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'product not found',
            ]);
    }
}
