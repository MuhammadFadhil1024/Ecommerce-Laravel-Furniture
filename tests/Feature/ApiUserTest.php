<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_success_get_data_user_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        User::factory()->create();

        $response = $this->get('api/v1/dashboard/users');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_failed_get_data_user_from_api_because_not_authenticated()
    {
        User::factory()->create();

        $response = $this->get('api/v1/dashboard/users');

        $response->assertStatus(302);
    }

    public function test_failed_get_data_user_from_api_because_roles_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        User::factory()->create();

        $response = $this->get('api/v1/dashboard/users');

        $response->assertStatus(302);
    }

    public function test_success_update_data_user_from_api()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $update_user = [
            'name' => 'user2',
            'email' => 'updateuser@gmail.com',
            'roles' => 'ADMIN'
        ];

        $response = $this->put('api/v1/dashboard/users/' . $user->id, $update_user);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data'])
            ->assertJson([
                'message' => 'success',
                'data' => [
                    'id' => $response->json('data.id'),
                    'name' => $response->json('data.name'),
                    'email' => $response->json('data.email'),
                    'roles' => $response->json('data.roles'),
                ]
            ]);
    }

    public function test_failed_update_data_user_because_validation()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $update_user = [
            'name' => 'user2',
            'email' => 'updateuser@gmail.com',
            'roles' => ''
        ];

        $response = $this->put('api/v1/dashboard/users/' . $user->id, $update_user);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'error'])
            ->assertJson([
                'message' => 'failed update user',
                'error' => [
                    'roles' => $response->json('error.roles')
                ]
            ]);
    }

    public function test_failed_update_data_user_because_user_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $update_user = [
            'name' => 'user2',
            'email' => 'updateuser@gmail.com',
            'roles' => 'ADMIN'
        ];

        $response = $this->put('api/v1/dashboard/users/' . 0, $update_user);

        $response->assertStatus(404)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'user not found',
            ]);
    }

    public function test_failed_update_data_user_because_not_authenticated()
    {
        $user = User::factory()->create();

        $update_user = [
            'name' => 'user2',
            'email' => 'updateuser@gmail.com',
            'roles' => 'ADMIN'
        ];

        $response = $this->put('api/v1/dashboard/users/' . $user->id, $update_user);

        $response->assertStatus(302);
    }

    public function test_failed_update_data_user_because_roles_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $update_user = [
            'name' => 'user2',
            'email' => 'updateuser@gmail.com',
            'roles' => 'ADMIN'
        ];

        $response = $this->put('api/v1/dashboard/users/' . $user->id, $update_user);

        $response->assertStatus(302);
    }

    public function test_success_delete_data_user()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $response = $this->delete('api/v1/dashboard/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'success'
            ]);
    }

    public function test_failed_delete_data_user_because_data_not_found()
    {
        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        User::factory()->create();

        $response = $this->delete('api/v1/dashboard/users/' . 0);

        $response->assertStatus(404)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'user not found'
            ]);
    }

    public function test_failed_delete_data_user_because_delete_own_account()
    {
        User::factory()->create();

        $user = User::factory()->create(['roles' => 'ADMIN']); // Create a user
        $this->actingAs($user);

        $response = $this->delete('api/v1/dashboard/users/' . $user->id);

        $response->assertStatus(422)
            ->assertJsonStructure(['message'])
            ->assertJson([
                'message' => 'You cannot delete your own account'
            ]);
    }

    public function test_failed_delete_data_user_because_not_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->delete('api/v1/dashboard/users/' . $user->id);

        $response->assertStatus(302);
    }

    public function test_failed_delete_data_user_because_roles_not_admin()
    {
        $user = User::factory()->create(['roles' => 'USER']); // Create a user
        $this->actingAs($user);

        $user = User::factory()->create();

        $response = $this->delete('api/v1/dashboard/users/' . $user->id);

        $response->assertStatus(302);
    }
}
