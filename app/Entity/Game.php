<?php

namespace App\Entity;

class Game
{
    private $id;
    /** @var Player[] */
    private $players = [];

    private $dealerPlayerId;

    private $smallBlindValue;
    private $smallBlindPlayerId;

    private $bigBlindValue;
    private $bigBlindPlayerId;

    private $activePlayerId;

    public function registerPlayer(string $id) : Game
    {
        $this->players[$id] = new Player();

        return $this;
    }

    public function getPlayerIds()
    {
        return array_keys($this->players);
    }

    public function setId(string $id) : Game
    {
        $this->id = $id;

        return $this;
    }

    public function setPlayersCards(array $playersCards) : Game
    {
        foreach ($playersCards as $playerId => $cardsOfPlayer)
        {
            $this->players[$playerId]->setCards($cardsOfPlayer);
        }

        return $this;
    }

    public function setDealerPlayerId(string $id) : Game
    {
        $this->dealerPlayerId = $id;

        return $this;
    }

    public function setSmallBlindValue(int $smallBlindValue) : Game
    {
        $this->smallBlindValue = $smallBlindValue;

        return $this;
    }

    public function setSmallBlindPlayerId(string $smallBlindPlayerId) : Game
    {
        $this->smallBlindPlayerId = $smallBlindPlayerId;

        return $this;
    }

    public function setBigBlindValue(int $bigBlindValue) : Game
    {
        $this->bigBlindValue = $bigBlindValue;

        return $this;
    }

    public function setBigBlindPlayerId(string $bigBlindPlayerId) : Game
    {
        $this->bigBlindPlayerId = $bigBlindPlayerId;

        return $this;
    }

    public function setActivePlayerId(string $activePlayerId) : Game
    {
        $this->activePlayerId = $activePlayerId;

        return $this;
    }
}