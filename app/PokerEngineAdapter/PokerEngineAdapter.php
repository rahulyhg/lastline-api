<?php

namespace App\PokerEngineAdapter;

use App\Entity\Game;
use GuzzleHttp\Client;

class PokerEngineAdapter implements PokerEngineAdapterInterface
{
    const POKER_ENGINE_URL = 'http://poker-service.fiterik.com';

    public function create(Game $game)
    {
        $data = $this->post('/game/create', ['players' => $game->getPlayerIds()]);

        $game
            ->setId($data['gameId'])
            ->setPlayersCards($data['playerCards'])
            ->setDealerPlayerId($data['dealer']['id'])
            ->setSmallBlindValue(20)
            ->setSmallBlindPlayerId($data['smallBlind']['id'])
            ->setBigBlindValue(40)
            ->setBigBlindPlayerId($data['smallBlind']['id'])
            ->setActivePlayerId($data['dealer']['id']);

        return $game;
    }

    private function post(string $uri, array $params = [])
    {
        $client = new Client(['base_uri' => self::POKER_ENGINE_URL]);

        $response = \GuzzleHttp\json_decode(
            $client->post($uri, ['form_params' => $params])->getBody(),
	        true
        );

        return $response;
    }
}