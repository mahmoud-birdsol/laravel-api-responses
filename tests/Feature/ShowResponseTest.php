<?php

namespace Alacrity\Responses\Tests\Feature;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class ShowResponseTest extends TestCase
{
    /** @test */
    public function it_fetches_a_transformed_model()
    {
        $user = factory(User::class)->create();

        $this->json('GET', "/api/user/{$user->id}")
             ->assertSuccessful()
             ->assertJson(['data' => $user->toArray()]);
    }
}