<?php

namespace App\MatchMaking\Entity;


class Player
{
	private $id;
	private $gameId;
	private $place;
	private $dealer;

	/**
	 * Player constructor.
	 *
	 * @param string $id
	 * @param int    $gameId
	 * @param int    $place
	 * @param int    $dealer
	 */
	public function __construct($id, $gameId, $place, $dealer)
	{
		$this->id = $id;
		$this->gameId = $gameId;
		$this->place = $place;
		$this->dealer = $dealer;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getGameId()
	{
		return $this->gameId;
	}

	/**
	 * @return int
	 */
	public function getPlace()
	{
		return $this->place;
	}

	/**
	 * @return int
	 */
	public function getDealer()
	{
		return $this->dealer;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'id'        => $this->getId(),
			'gameId'    => $this->getGameId(),
			'place'     => $this->getPlace(),
			'dealer'    => $this->getDealer()
		];
	}
}