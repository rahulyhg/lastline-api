<?php

namespace App\Http\Controllers\Api;

use App\MatchMaking\Repository\MatchMakingRepository;
use App\MatchMaking\Model\MatchMakingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchMakingController extends Controller
{
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function register()
    {
    	$matchMakingRepository = new MatchMakingRepository();
	    $matchMaking           = new MatchMakingModel($matchMakingRepository);

	    $queue = $matchMaking->registerUserToQueue(auth()->user());

	    return [
	    	'success' => true
	    ];
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
    public function cancel()
    {
	    $matchMakingRepository = new MatchMakingRepository();
	    $matchmaking           = new MatchMakingModel($matchMakingRepository);

	    $success = $matchmaking->cancel(auth()->user());

	    return [
	    	'success' => $success
	    ];
    }
}
