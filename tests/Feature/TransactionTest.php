<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_transaction_screen_can_be_rendered()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        Transaction::factory()->create();

        $response = $this->get('dashboard/transaction');
        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard.transaction.index');
    }

    public function test_show_detail_transaction_can_be_redered()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->get(route('dashboard.transaction.show', $transaction->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard.transaction.show');
    }

    public function test_edit_page_transaction_can_be_redered()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->get(route('dashboard.transaction.edit', $transaction->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard.transaction.edit');
    }

    public function test_users_can_update_transaction()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $transaction = Transaction::factory()->create();

        $response = $this->put(route('dashboard.transaction.update', $transaction->id), [
            'name' => 'Fadhil Muhammad',
            'email' => $transaction->email,
            'address' => $transaction->address,
            'phone' => $transaction->phone,
            'courier' => $transaction->courier,
            'total_price' => $transaction->total_price,
            'status' => $transaction->status,
        ]);
        $response->assertStatus(302);
        $response->assertRedirectToRoute('dashboard.transaction.index');
    }
}
