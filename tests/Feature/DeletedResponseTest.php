<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class DeletedResponseTest extends TestCase
{
    /** @test */
    public function it_returns_a_successful_deleted_Response()
    {
        $user = factory(User::class)->create();

        $this->json('DELETE', "/api/user/{$user->id}")->assertStatus(204);
    }
}