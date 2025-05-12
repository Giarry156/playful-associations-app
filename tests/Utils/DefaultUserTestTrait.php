<?php

namespace Tests\Utils;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait DefaultUserTestTrait
{
    private array $defaultUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defaultUser = $this->defaultUser();
    }

    protected function defaultUser(): array
    {
        // Retrieving default user or creating it.
        $user = User::firstOrCreate(
            ['email' => 'bernildo@test.it'],
            [
                'name' => 'Bernildo Arturo',
                'password' => Hash::make('password'),
            ]
        );

        // Returning spot.
        return [
            'email' => $user->email,
            'password' => 'password',
            'instance' => $user,
        ];
    }

    protected function getDefaultUserToken(): string
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                '/api/users/login',
                [
                    'email' => $this->defaultUser['email'],
                    'password' => $this->defaultUser['password'],
                ]
            );

        return $response->getOriginalContent()['data']['token'];
    }
}
