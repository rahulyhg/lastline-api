<?php

namespace App\User\Model;

use App\User;
use App\User\Repository\UserRepository;
use Auth;

class UserModel
{
	/** @var UserRepository  */
	private $userRepository;

	/**
	 * UserModel constructor.
	 *
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Create user from session.
	 *
	 * @return User
	 */
	public function createUser()
	{
		return $this->userRepository->createUser();
	}
}