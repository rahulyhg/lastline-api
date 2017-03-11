<?php

namespace App\Entity;

class Player
{
    private $cards;

    public function setCards(array $cards) : Player
    {
        $this->cards = $cards;

        return $this;
    }
}