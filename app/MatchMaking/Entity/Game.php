<?php

namespace App\MatchMaking\Entity;

class Game
{
	/** @var string  */
	private $gameToken;

	/** @var int  */
	private $gameId;

	/** @var int  */
	private $smallBlindValue;

	/** @var int  */
	private $bigBlindValue;

	/** @var array  */
	private $playerCards;

	/** @var Player  */
	private $dealer;

	/** @var Player */
	private $bigBlind;

	/** @var Player */
	private $smallBlind;

	/** @var Player */
	private $activePlayer;

	/**
	 * Game constructor.
	 *
	 * @param string    $gameToken
	 * @param int      $gameId
	 * @param int       $smallBlindValue
	 * @param int       $bigBlindValue
	 * @param array     $playerCards
	 * @param Player    $dealer
	 * @param Player    $bigBlind
	 * @param Player    $smallBlind
	 * @param Player    $activePlayer
	 */
	public function __construct(
		$gameToken,
		$gameId,
		$smallBlindValue,
		$bigBlindValue,
		array $playerCards,
		Player $dealer,
		Player $bigBlind,
		Player $smallBlind,
		Player $activePlayer
	)
	{
		$this->gameToken = $gameToken;
		$this->gameId = $gameId;
		$this->smallBlindValue = $smallBlindValue;
		$this->bigBlindValue = $bigBlindValue;
		$this->playerCards   = $playerCards;
		$this->dealer = $dealer;
		$this->bigBlind = $bigBlind;
		$this->smallBlind = $smallBlind;
		$this->activePlayer = $activePlayer;
	}

	/**
	 * @return string
	 */
	public function getGameToken(): string
	{
		return $this->gameToken;
	}

	/**
	 * @return int
	 */
	public function getGameId(): int
	{
		return $this->gameId;
	}

	/**
	 * @return int
	 */
	public function getSmallBlindValue(): int
	{
		return $this->smallBlindValue;
	}

	/**
	 * @return int
	 */
	public function getBigBlindValue(): int
	{
		return $this->bigBlindValue;
	}

	/**
	 * @return array
	 */
	public function getPlayerCards() : array
	{
		return $this->playerCards;
	}

	/**
	 * @return Player
	 */
	public function getDealer(): Player
	{
		return $this->dealer;
	}

	/**
	 * @return Player
	 */
	public function getBigBlind(): Player
	{
		return $this->bigBlind;
	}

	/**
	 * @return Player
	 */
	public function getSmallBlind(): Player
	{
		return $this->smallBlind;
	}

	/**
	 * @return Player
	 */
	public function getActivePlayer(): Player
	{
		return $this->activePlayer;
	}

	/**
	 * @return array
	 */
	public function toArray() : array
	{
		return [
			'token'             => $this->getGameToken(),
			'gameId'            => $this->getGameId(),
			'smallBlindValue'   => $this->getSmallBlindValue(),
			'bigBlindValue'     => $this->getBigBlindValue(),
			'dealer'            => $this->getDealer()->toArray(),
			'bigBlind'          => $this->getBigBlind()->toArray(),
			'smallBlind'        => $this->getSmallBlind()->toArray(),
			'activePlayer'      => $this->getActivePlayer()->toArray()
		];
	}

}