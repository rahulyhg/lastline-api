<?php

namespace App\PokerEngineAdapter;

use App\MatchMaking\Entity\Player;
use App\MatchMaking\Entity\Game;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class PokerEngineAdapter 
{
    const POKER_ENGINE_URL = 'http://poker-service.fiterik.com';

	/**
	 * @param Collection $players
	 *
	 * @return Game
	 */
    public function createGame(Collection $players) : Game
    {
	    $users = [];
	    $requestUserIds = [];
    	foreach($players as $player)
	    {
	    	$users[$player->id] = $player->username;
		    $requestUserIds[] = $player->id;
	    }

    	$response = $this->post('/game/create', [
    		'playerIds' => $requestUserIds
	    ]);

    	// meghaxoltam a kurva életbe
    	foreach($response['players'] as $i => $player)
    	{
    		$response['players'][$i]['username'] = $users[$player['id']];
	    }

    	return $this->buildGameEntity($response);
    }


    public function gameCheck()
    {

    }

	/**
	 * @return array
	 */
    public function gameFold()
    {
	    $response = $this->get('/game/fold');

	    return $response;
    }

	/**
	 * @param $coins
	 *
	 * @return array
	 */
    public function gameRaise($coins)
    {
	    $response = $this->post('/game/raise', [
	    	'coins' => $coins
	    ]);

	    return $response;
    }

    public function gameCall()
    {
	    $response = $this->get('/game/call');

	    return $response;
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
		    $player['coins'],
		    $player['hand'],
		    $player['username']
	    );
    }

	/**
	 * @param array $params
	 *
	 * @return Game
	 */
    public function buildGameEntity(array $params) : Game
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
		    $params['dealer'],
	        $params['smallBlindPlayer'],
	        $params['bigBlindPlayer'],
	        $params['nextPlayer'],
		    $params['pot']
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

	/**
	 * @param string $uri
	 * @param array  $params
	 *
	 * @return mixed
	 */
	private function get(string $uri, array $params = [])
	{
		$client = new Client(['base_uri' => self::POKER_ENGINE_URL]);

		$response = \GuzzleHttp\json_decode(
			$client->get($uri, ['form_params' => $params])->getBody(),
			true
		);

		return $response;
	}
}