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
    		'playerIds' => $playerIds
	    ]);

    	return $this->buildGameEntity($response);
    }


    public function gameCheck()
    {

    }

    public function gameFold()
    {
	    $response = $this->post('/game/fold');

	    return $response;
    }

    public function gameRaise()
    {

    }

    public function gameCall()
    {

    }

	/**
	 * @param array $player
	 *
	 * @return Player
	 */
    private function createPlayerEntity(array $player) : Player
    {
    	return new Player(
    		$player['id']['id'],
		    $player['coins'],
		    $player['hand']
	    );
    }

	/**
	 * @param array $params
	 *
	 * @return Game
	 */
    private function buildGameEntity(array $params) : Game
    {
    	$players = [];
    	foreach($params['players'] as $player)
    	{
            $players[] = $this->createPlayerEntity($player);
	    }

    	return new Game(
    		$players,
		    $params['smallBlind'],
	        $params['bigBlind'],
		    $params['dealer']['id'],
	        $params['smallBlindPlayer']['id'],
	        $params['bigBlindPlayer']['id'],
	        $params['currentPlayer']['id']
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