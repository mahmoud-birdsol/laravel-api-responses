<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class UpdatedResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_successful_updated_response()
    {
        $user = factory(User::class)->create();
        $data = ['name' => 'John Doe'];

        $this->json('PATCH', "/api/user/{$user->id}", $data)
             ->assertStatus(202);
    }

    /** @test */
    public function it_returns_a_successful_updated_response_with_the_updated_model()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $data = ['name' => 'John Doe'];

        $responseData = $user->toArray();
        $responseData['name'] = 'John Doe';

        $this->json('PATCH', "/api/user-with-model/{$user->id}", $data)
             ->assertStatus(202)
             ->assertJson(['data' => $responseData]);
    }
}