<?php

namespace App\MatchMaking\Entity;

class Game
{
	/** @var Player[] */
	private $players;

	/** @var int  */
	private $smallBlind;

	/** @var int  */
	private $bigBlind;

	/** @var string  */
	private $dealer;

	/** @var string  */
	private $smallBlindPlayer;

	/** @var string  */
	private $bigBlindPlayer;

	/** @var string  */
	private $currentPlayer;

	/**
	 * Game constructor.
	 *
	 * @param Player[]  $players
	 * @param int       $smallBlind
	 * @param int       $bigBlind
	 * @param string    $dealer
	 * @param string    $smallBlindPlayer
	 * @param string    $bigBlindPlayer
	 * @param string    $currentPlayer
	 */
	public function __construct(
		array $players,
		$smallBlind,
		$bigBlind,
		$dealer,
		$smallBlindPlayer,
		$bigBlindPlayer,
		$currentPlayer
	)
	{
		$this->players = $players;
		$this->smallBlind = $smallBlind;
		$this->bigBlind = $bigBlind;
		$this->dealer = $dealer;
		$this->smallBlindPlayer = $smallBlindPlayer;
		$this->bigBlindPlayer = $bigBlindPlayer;
		$this->currentPlayer = $currentPlayer;
	}

	/**
	 * @return Player[]
	 */
	public function getPlayers(): array
	{
		return $this->players;
	}

	/**
	 * @return int
	 */
	public function getSmallBlind(): int
	{
		return $this->smallBlind;
	}

	/**
	 * @return int
	 */
	public function getBigBlind(): int
	{
		return $this->bigBlind;
	}

	/**
	 * @return string
	 */
	public function getDealer(): string
	{
		return $this->dealer;
	}

	/**
	 * @return string
	 */
	public function getSmallBlindPlayer(): string
	{
		return $this->smallBlindPlayer;
	}

	/**
	 * @return string
	 */
	public function getBigBlindPlayer(): string
	{
		return $this->bigBlindPlayer;
	}

	/**
	 * @return string
	 */
	public function getCurrentPlayer(): string
	{
		return $this->currentPlayer;
	}


	/**
	 * @return array
	 */
	public function toArray() : array
	{
		$players = [];
		foreach($this->getPlayers() as $player)
		{
			$currentPlayer = $player->toArray();
			unset($currentPlayer['hand']);
			$players[] = $currentPlayer;
		}

		return [
			'smallBlind'        => $this->getSmallBlind(),
			'bigBlind'          => $this->getBigBlind(),
			'dealer'            => $this->getDealer(),
			'bigBlindPlayer'    => $this->getBigBlindPlayer(),
			'smallBlindPlayer'  => $this->getSmallBlindPlayer(),
			'currentPlayer'     => $this->getCurrentPlayer(),
			'players'           => $players
		];
	}

}