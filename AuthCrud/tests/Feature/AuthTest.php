<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration, login, me, update account, and logout.
     *
     * @return void
     */
    public function test_auth_operations()
    {
        // Registro de usuario
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $registerResponse = $this->postJson('http://localhost:8000/api/auth/register', $userData);

        $registerResponse->assertStatus(201)
                         ->assertJsonStructure([
                             'id',
                             'name',
                             'email',
                             'created_at',
                             'updated_at',
                         ]);

        
        $loginCredentials = [
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ];

        $loginResponse = $this->postJson('http://localhost:8000/api/auth/login', $loginCredentials);

        $loginResponse->assertStatus(200)
                      ->assertJsonStructure([
                          'access_token',
                          'token_type',
                          'expires_in',
                      ]);

        
        $token = $loginResponse['access_token'];

        $meResponse = $this->get('http://localhost:8000/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $meResponse->assertStatus(200)
                   ->assertJsonFragment([
                       'email' => 'john.doe@example.com',
                   ]);

        
        $updatedUserData = [
            'name' => 'John Doe Updated',
            'email' => 'john.doe.updated@example.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $updateResponse = $this->putJson('http://localhost:8000/api/auth/update-account', $updatedUserData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $updateResponse->assertStatus(200)
                       ->assertJsonFragment([
                           'message' => 'Account updated successfully',
                       ]);

         $user = User::where('email', 'john.doe.updated@example.com')->first();
         $this->assertNotNull($user);
         $deleteResponse = $this->deleteJson('http://localhost:8000/api/auth/users/' . $user->id, [], [
             'Authorization' => 'Bearer ' . $token,
         ]);
         $deleteResponse->assertStatus(200)
                        ->assertJsonFragment([
                            'message' => 'User deleted successfully',
                        ]);

        
        $logoutResponse = $this->postJson('http://localhost:8000/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $logoutResponse->assertStatus(200)
                       ->assertJsonFragment([
                           'message' => 'Successfully logged out',
                       ]);

         
         
    }
}
