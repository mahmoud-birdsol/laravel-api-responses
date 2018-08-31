<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class UpdatedResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_successful_updated_response_with_the_updated_model()
    {
        $user = factory(User::class)->create();
        $data = ['name' => 'John Doe'];

        $this->json('PATCH', "/api/user/{$user->id}", $data)->assertStatus(202);
    }
}