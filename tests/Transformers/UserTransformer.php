<?php

namespace Alacrity\Responses\Tests\Transformers;

use Alacrity\Responses\Tests\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	/**
	 * Transform the specified resource.
	 * @param  User   $user
	 * @return array
	 */
	public function transform(User $user)
	{
		return $user->toArray();
	}
}
