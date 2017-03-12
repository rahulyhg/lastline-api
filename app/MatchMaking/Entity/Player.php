<?php

namespace App\MatchMaking\Entity;


class Player
{
	private $id;
	private $coins;
	private $hand;

	/**
	 * Player constructor.
	 *
	 * @param string $id
	 * @param int    $coins
	 * @param array  $hand
	 */
	public function __construct($id, $coins, array $hand)
	{
		$this->id    = $id;
		$this->coins = $coins;
		$this->hand  = $hand;
	}

	/**
	 * @return string
	 */
	public function getId() : string
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getCoins() : int
	{
		return $this->coins;
	}

	/**
	 * @return array
	 */
	public function getHand() : array
	{
		return $this->hand;
	}

	/**
	 * @return array
	 */
	public function toArray() : array
	{
		return [
			'id'       => $this->getId(),
			'coins'    => $this->getCoins(),
			'hand'     => $this->getHand()
		];
	}
}