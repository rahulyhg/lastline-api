<?php

namespace App\PokerEngineAdapter;

use App\Entity\Game;

interface PokerEngineAdapterInterface
{
    public function create(Game $game);
}