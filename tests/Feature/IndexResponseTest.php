<?php

namespace Alacrity\Responses\Tests;

use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\TestCase;

class IndexResponseTest extends TestCase
{
	/** @test */
	// public function it_fetches_a_transformed_list_of_the_resource()
	// {
	// 	$users = factory(User::class, 10)->create();

	// 	$this->json('GET', '/api/user')
	// 		 ->assertSuccessful()
	// 		 ->assertJson(['data' => $users->toArray()]);
	// }

	/** @test */
	public function it_fetches_a_paginated_transformed_list_of_the_resource()
	{
		$users = factory(User::class, 10)->create()->take(2);
		$perPage = 2;

		$res = $this->json('GET', '/api/user', ['paginate' => $perPage])
			 ->assertSuccessful()
			 ->assertJson(['data' => $users->toArray(),'meta' =>['pagination' => [
 				'total' => 10,
			 	'count' => $perPage,
			 	'per_page' => $perPage,
			 	'current_page' => 1,
			 	'total_pages' => 5,
			]]]);
	}
}
