<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\TestCase;
use Alacrity\Responses\Tests\Models\User;

class CreatedResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_successful_created_response()
    {
        $data = factory(User::class)->raw();

        $this->json('POST', '/api/user', $data)->assertStatus(201);
    }

    /** @test */
    public function it_returns_the_Created_user_with_response()
    {
        $data = factory(User::class)->raw();

        $this->json('POST', '/api/user-with-model', $data)
             ->assertStatus(201)
             ->assertJson(['data' => $data]);
    }
}
