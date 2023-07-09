<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_success_get_transaction_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data']);
    }


    public function test_failed_get_transaction_from_api_because_not_authenticate()
    {
        Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction');

        $response->assertStatus(302);
    }

    public function test_failed_get_transaction_from_api_because_roles_users_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction');

        $response->assertStatus(302);
    }



    public function test_success_update_status_transaction_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $update_transaction = [
            'status' => 'SUCCESS'
        ];

        $response = $this->put('api/v1/dashboard/transaction/' . $transaction->id, $update_transaction);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'id_users' => $response->json('data.id_users'),
                    'name' => $response->json('data.name'),
                    'email' => $response->json('data.email'),
                    'address' => $response->json('data.address'),
                    'phone' => $response->json('data.phone'),
                    'courier' => $response->json('data.courier'),
                    'payment' => $response->json('data.payment'),
                    'payment_url' => $response->json('data.payment_url'),
                    'total_price' => $response->json('data.total_price'),
                    'status' => $response->json('data.status'),
                ]
            ]);
    }

    public function test_failed_update_transaction_from_api_because_data_transaction_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);


        Transaction::factory()->create();

        $update_transaction = [
            'status' => 'SUCCESS'
        ];

        $response = $this->put('api/v1/dashboard/transaction/' . 0, $update_transaction);

        $response->assertStatus(404)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'transaction not found',]);
    }

    public function test_failed_update_transaction_from_api_because_validation()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->put('api/v1/dashboard/transaction/' . $transaction->id);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'error'])
            ->assertJson([
                'message' => 'failed update status transaction',
                'error' => [
                    'status' => $response->json('error.status')
                ]
            ]);
    }

    public function test_failed_update_transaction_from_api_because_roles_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $update_transaction = [
            'status' => 'SUCCESS'
        ];

        $response = $this->put('api/v1/dashboard/transaction/' . $transaction->id, $update_transaction);

        $response->assertStatus(302);
    }

    public function test_failed_transaction_from_api_because_user_not_autehenticated()
    {
        $transaction = Transaction::factory()->create();

        $update_transaction = [
            'status' => 'SUCCESS'
        ];

        $response = $this->put('api/v1/dashboard/transaction/' . $transaction->id, $update_transaction);

        $response->assertStatus(302);
    }

    public function test_success_show_detail_transaction()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction/' . $transaction->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'id_users' => $response->json('data.id_users'),
                    'name' => $response->json('data.name'),
                    'email' => $response->json('data.email'),
                    'address' => $response->json('data.address'),
                    'phone' => $response->json('data.phone'),
                    'courier' => $response->json('data.courier'),
                    'payment' => $response->json('data.payment'),
                    'payment_url' => $response->json('data.payment_url'),
                    'total_price' => $response->json('data.total_price'),
                    'status' => $response->json('data.status'),
                ]
            ]);
    }

    public function test_failed_show_data_transaction_because_data_transaction_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction/' . 0);

        $response->assertStatus(404)
            ->assertJsonStructure(["message"])
            ->assertJson([
                "message" => "transaction not found"
            ]);
    }

    public function test_failed_show_data_transaction_beacause_not_authenticated()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction/' . $transaction->id);

        $response->assertStatus(302);
    }

    public function test_failed_show_data_transaction_beacause_roles_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->get('api/v1/dashboard/transaction/' . $transaction->id);

        $response->assertStatus(302);
    }
}
