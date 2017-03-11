<?php

namespace App\PokerEngineAdapter;

use App\MatchMaking\Entity\Player;
use App\MatchMaking\Entity\Game;
use GuzzleHttp\Client;

class PokerEngineAdapter 
{
    const POKER_ENGINE_URL = 'http://poker-service.fiterik.com';

	/**
	 * @param array $playerIds
	 *
	 * @return Game
	 */
    public function createGame(array $playerIds) : Game
    {
    	$response = $this->post('/game/create', [
    		'players' => $playerIds
	    ]);

    	return $this->buildGameEntity($response);
    }

	/**
	 * @param array $player
	 *
	 * @return Player
	 */
    private function createPlayerEntity(array $player) : Player
    {
    	return new Player(
    		$player['id'],
		    $player['gameId'],
		    $player['place']
	    );
    }

	/**
	 * @param array $params
	 *
	 * @return Game
	 */
    private function buildGameEntity(array $params) : Game
    {
    	return new Game(
    		$params['gameToken'],
		    $params['gameId'],
		    $params['smallBlindValue'],
		    $params['bigBlindValue'],
		    $params['playerCards'],
		    $this->createPlayerEntity($params['dealer']),
		    $this->createPlayerEntity($params['bigBlind']),
			$this->createPlayerEntity($params['smallBlind']),
			$this->createPlayerEntity($params['activePlayer'])
        );
    }

	/**
	 * @param string $uri
	 * @param array  $params
	 *
	 * @return mixed
	 */
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