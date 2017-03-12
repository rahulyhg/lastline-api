<?php

namespace App\Game\Model;

use App\Current;
use App\Events\GameCall;
use App\Events\GameFold;
use App\Events\GameRaise;
use App\Events\GameWinner;
use App\MatchMaking\Entity\Game;
use App\MatchMaking\Entity\Player;
use App\MatchMaking\Model\MatchMakingModel;
use App\MatchMaking\Repository\MatchMakingRepository;
use App\PokerEngineAdapter\PokerEngineAdapter;

class GameModel
{
	/** @var PokerEngineAdapter  */
	private $pokerRepository;

	/**
	 * GameModel constructor.
	 *
	 * @param PokerEngineAdapter $pokerRepository
	 */
	public function __construct(PokerEngineAdapter $pokerRepository)
	{
		$this->pokerRepository = $pokerRepository;
	}

	/**
	 * @return array
	 */
	public function fold()
	{

		$response       = $this->pokerRepository->gameFold();

		$this->handleResponse($response, 'fold');

		return $response;
	}

	/**
	 * @param int $coins
	 *
	 * @return array
	 */
	public function raise($coins)
	{
		$response = $this->pokerRepository->gameRaise($coins);

		$this->handleResponse($response, 'raise');

		return $response;
	}

	/**
	 * @param array $response
	 */
	private function handleResponse(array $response, $action)
	{
		$currentPlayers = Current::with('user')->get();

		foreach($currentPlayers as $player)
		{
			switch($action)
			{
				case 'fold':
					broadcast(new GameFold($player->user_id, $response));
					break;

				case 'raise':
					broadcast(new GameRaise($player->user_id, $response));
					break;

				case 'call':
					broadcast(new GameCall($player->user_id, $response));
					break;
			}
		}

		if (isset($response['winner']))
		{
			sleep(5);
			$matchmakingModel = new MatchMakingModel(new MatchMakingRepository());
			$pokerRepository  = new PokerEngineAdapter();

			$playerNamesInArray = [];
			foreach($currentPlayers as $currentPlayer)
			{
				$playerNamesInArray[$currentPlayer->user_id] = $currentPlayer->user->username;
			}

			foreach($response['players'] as $i => $player)
			{
				$response['players'][$i]['username'] = $playerNamesInArray[$player['id']];
			}

			$game = $pokerRepository->buildGameEntity($response);

			$matchmakingModel->startGame($game, $currentPlayers->pluck('user'));
		}
	}

	/**
	 *
	 */
	public function call()
	{
		$response = $this->pokerRepository->gameCall();

		$this->handleResponse($response, 'call');

		return $response;
	}
}