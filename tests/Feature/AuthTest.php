<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRegisterSuccessfully()
    {
        $register = [
            'name' => 'UserTest',
            'email' => 'user@test.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ];

        $this->json('POST', 'api/register', $register)
            ->assertStatus(201);
    }

    public function testRequireEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testUserLoginSuccessfully()
    {
        $user = ['email' => 'user@test.com', 'password' => 'testpass'];

        $this->json('POST', 'api/login', $user)
            ->assertStatus(200);
    }
}
