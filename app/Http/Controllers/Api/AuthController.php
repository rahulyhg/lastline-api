<?php

namespace App\Http\Controllers\Api;

use Auth;
use JWTAuth;
use App\User\Model\UserModel;
use App\User\Repository\UserRepository;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

	/**
	 * Ellenőrzi, hogy a él-e még a session
	 *
	 * @return array
	 */
    public function check()
    {
    	if(auth()->check())
	    {
	    	return [
	    		'success' => true,
			    'data'    => [
			    	'user' => auth()->user(),
				    'token' => JWTAuth::getToken()
			    ]
		    ];
	    }

	    return [
	    	'success' => false
	    ];
    }

	/**
	 * @return array
	 */
    public function register()
    {
	    $userRepository = new UserRepository();
	    $userModel = new UserModel($userRepository);

	    $user = $userModel->createUser();

	    $token = JWTAuth::fromUser($user);

		return [
			'success' => true,
			'data' => [
				'user' => $user,
				'token' => $token
			]
		];
    }
}
