<?php

namespace App\Game\Model;

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
	 * @return \App\MatchMaking\Entity\Game
	 */
	public function fold()
	{
		return $this->pokerRepository->gameFold();
	}
}