<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{

	/**
	 * @return array
	 */
    public function check(Request $request)
    {
		return [
			'foo' => 'asd'
		];
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function fold(Request $request)
	{
		return [
			'foo' => 'asd'
		];
	}

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function raise(Request $request)
	{
		return [
			'foo' => 'asd'
		];
	}

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function call(Request $request)
	{
		return [
			'foo' => 'asd'
		];
	}
}
