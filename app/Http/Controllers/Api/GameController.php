<?php

namespace App\Http\Controllers\Api;

use App\Game\Model\GameModel;
use App\MatchMaking\Model\MatchMakingModel;
use App\MatchMaking\Repository\MatchMakingRepository;
use App\PokerEngineAdapter\PokerEngineAdapter;
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
		$pokerEngine = new PokerEngineAdapter();
		$gameModel   = new GameModel($pokerEngine);

		$gameModel->fold();

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
