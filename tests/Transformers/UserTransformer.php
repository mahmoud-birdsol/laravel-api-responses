<?php

namespace Alacrity\Responses\Tests\Transformers;

use League\Fractal\TransformerAbstract;
use Alacrity\Responses\Tests\Models\User;

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
