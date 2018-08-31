<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class CreatedResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_successful_created_response()
    {
        $data = factory(User::class)->raw();

        $this->json('POST', '/api/user', $data)->assertStatus(201);
    }
}