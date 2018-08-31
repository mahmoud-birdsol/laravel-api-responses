<?php

namespace Alacrity\Responses\Tests\Unit;

use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;
use Alacrity\Responses\Tests\Transformers\UserTransformer;
use Illuminate\Contracts\Support\Responsable;

class IndexResponseTest extends TestCase
{
	/** @test */
	public function it_implements_the_responsable_interface()
	{
		$response = new IndexResponse(User::query(), new UserTransformer());

		$this->assertInstanceOf(Responsable::class, $response);
	}
}
