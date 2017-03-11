<?php

namespace App\PokerEngineAdapter;

use App\Entity\Game;
use GuzzleHttp\Client;

class PokerEngineAdapter implements PokerEngineAdapterInterface
{
    const POKER_ENGINE_URL = '';

    public function create(Game $game)
    {
        $data = $this->post('create', ['players' => $game->getPlayerIds()]);

        $game
            ->setId($data['game_id'])
            ->setPlayersCards($data['player_cards'])
            ->setDealerPlayerId($data['dealer'])
            ->setSmallBlindValue($data['small_blind_value'])
            ->setSmallBlindPlayerId($data['small_blind_player'])
            ->setBigBlindPlayerId($data['big_blind_value'])
            ->setBigBlindPlayerId($data['big_blind_player'])
            ->setActivePlayerId($data['active_player']);
    }

    private function post(string $uri, array $params = [])
    {
        $client = new Client(['base_uri' => self::POKER_ENGINE_URL]);

        $response = \GuzzleHttp\json_decode(
            $client->post($uri, ['form_params' => $params])->getBody()
        );

        return $response['data'];
    }
}