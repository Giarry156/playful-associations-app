<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Utils\DefaultUserTestTrait;

class UserTest extends TestCase
{
    use DefaultUserTestTrait;

    const USERS_URL = '/api/users';

    public function test_registration_failed_for_invalid_body(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/register',
                [
                    'name' => '',
                    'email' => 'invalid-email',
                    'password' => 'short',
                ]
            );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name',
            'email',
            'password',
        ]);
    }

    /**
     * Testing the registration of a user with valid data.
     */
    public function test_successful_registration(): void
    {
        $email = 'test' . time() . '@example.com';
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/register',
                [
                    'name' => 'test',
                    'email' => $email,
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]
            );

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function test_registration_failed_for_existing_email(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/register',
                [
                    'name' => 'test',
                    'email' => $this->defaultUser['email'],
                    'password' => 'password',
                ]
            );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }

    public function test_login_failed_for_invalid_body(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/login',
                [
                    'email' => '',
                    'password' => '',
                ]
            );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
            'password',
        ]);
    }

    public function test_login_failed_for_invalid_credentials(): void
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/login',
                [
                    'email' => $this->defaultUser['email'],
                    'password' => 'wrong-password',
                ]
            );

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Invalid credentials'
        ]);
    }

    public function test_successful_login(): void
    {
        // Defining default user for testing.
        $response = $this->withHeader('Accept', 'application/json')
            ->post(
                self::USERS_URL . '/login',
                [
                    'email' => $this->defaultUser['email'],
                    'password' => $this->defaultUser['password'],
                ]
            );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }
}
