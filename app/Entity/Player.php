<?php

namespace App\Entity;

class Player
{
    private $cards;
    private $hand;

    public function setCards(array $cards) : Player
    {
        $this->cards = $cards;

        return $this;
    }

    public function getCards() : array
    {
        return $this->cards;
    }

    public function setHand(array $hand) : Player
    {
        $this->hand = $hand;

        return $this;
    }

    public function getHand() : array
    {
        return $this->hand;
    }
}