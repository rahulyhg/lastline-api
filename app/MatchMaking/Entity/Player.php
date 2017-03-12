<?php

namespace App\MatchMaking\Entity;


class Player
{
	private $id;
	private $coins;
	private $hand;
	private $name;

	/**
	 * Player constructor.
	 *
	 * @param string $id
	 * @param int    $coins
	 * @param array  $hand
	 * @param string $name
	 */
	public function __construct($id, $coins, array $hand, $name)
	{
		$this->id    = $id;
		$this->coins = $coins;
		$this->hand  = $hand;
		$this->name  = $name;
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
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function toArray() : array
	{
		return [
			'id'       => $this->getId(),
			'coins'    => $this->getCoins(),
			'hand'     => $this->getHand(),
			'name'     => $this->getName()
		];
	}
}