<?php

namespace Alacrity\Responses\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

    /**
     * Filter to users with a specific email.
     *
     * @param $query
     * @param $email
     * @return mixed
     */
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
	}
}
