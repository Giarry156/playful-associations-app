<?php

namespace Tests\Feature;

use App\Models\Association;
use Database\Factories\AssociationFactory;
use Tests\TestCase;
use Tests\Utils\DefaultUserTestTrait;

class AssociationTest extends TestCase
{
    use DefaultUserTestTrait;

    const ASSOCIATIONS_URL = '/api/associations';

    public function test_association_bind_failed_for_no_auth_token_request()
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::ASSOCIATIONS_URL . '/1/bind',
                [
                    'association_id' => 1,
                ]
            );

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_association_bind()
    {
        $association = Association::all()->diff($this->defaultUser['instance']->associations)->first();

        // First bind.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::ASSOCIATIONS_URL . '/' . $association->id . '/bind'
            );

        $response->assertStatus(201);

        // Double bind.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::ASSOCIATIONS_URL . '/' . $association->id . '/bind'
            );

        $response->assertStatus(201);
    }

    public function test_association_unbind_failed_for_no_auth_token_request()
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(
                self::ASSOCIATIONS_URL . '/1/unbind',
                [
                    'association_id' => 1,
                ]
            );

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_association_unbind()
    {
        $association = $this->defaultUser['instance']->associations->where('president_id', '!=', $this->defaultUser['instance']->id)->first();
        if (!$association) {
            $this->defaultUser['instance']->associations()->attach(1);
            $association = Association::find(1);
        }

        // First unbind.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::ASSOCIATIONS_URL . '/' . $association->id . '/unbind'
            );

        $response->assertStatus(200);

        // Second unbind.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::ASSOCIATIONS_URL . '/' . $association->id . '/unbind'
            );

        $response->assertStatus(200);
    }

    public function test_association_unbind_failed_for_user_presidency()
    {
        $association = $this->defaultUser['instance']->associations->where('president_id', $this->defaultUser['instance']->id)->first();
        if (!$association) {
            $association = Association::factory(1)->create([
                'president_id' => $this->defaultUser['instance']->id,
            ])->first();
        }

        // First unbind.
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->getDefaultUserToken())
            ->post(
                self::ASSOCIATIONS_URL . '/' . $association->id . '/unbind'
            );

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'User is the president of this association and cannot be unbound',
        ]);
    }
}
