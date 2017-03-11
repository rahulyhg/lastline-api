<?php

namespace App\User\Repository;


use App\User;

class UserRepository
{
	/**
	 * Létrehoz egy új usert név és session id alapján
	 *
	 * @return User
	 */
	public function createUser()
	{
		$user = factory(User::class)->create();

		return $user;
	}
}