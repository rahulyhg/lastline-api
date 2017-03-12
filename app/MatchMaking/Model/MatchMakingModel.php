<?php

namespace App\MatchMaking\Model;

use App\Current;
use App\Events\DealCard;
use App\Events\GameHasCreated;
use App\MatchMaking\Entity\Game;
use App\MatchMakingQueue;
use App\PokerEngineAdapter\PokerEngineAdapter;
use App\User;
use App\MatchMaking\Repository\MatchMakingRepository;
use Illuminate\Support\Collection;

class MatchMakingModel
{
	/** @var MatchMakingRepository  */
	private $matchMakingRepository;

	/**
	 * MatchMakingModel constructor.
	 *
	 * @param MatchMakingRepository $makingRepository
	 */
	public function __construct(MatchMakingRepository $makingRepository)
	{
		$this->matchMakingRepository = $makingRepository;
	}

	/**
	 * Hozzáadja a felhasználót a queuehoz.
	 *
	 * @param User $user
	 *
	 * @return MatchMakingQueue
	 */
	public function registerUserToQueue(User $user) : MatchMakingQueue
	{
		$this->cancel($user);

		$matchMakingQueue = $this->matchMakingRepository->addUserToQueue($user);

		return $matchMakingQueue;
	}

	/**
	 * Eltávolítja a felhasználót a queueból.
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function cancel(User $user) : bool
	{
		$result = $this->matchMakingRepository->removeUserFromQueue($user);

		return $result;
	}

	public function findMatch()
	{
		$minPlayers = config('matchmaking.playersMin');
		$maxPlayers = config('matchmaking.playersMax');
		$waiting    = $this->matchMakingRepository->allWaitingPlayers();

		// ha kevesebb van a minimálisnál, akkor nem csinálunk meccset
		if($waiting->count() <= $minPlayers)
		{
			logger()->info('Nincs elég ember party készítéshez. Várakozunk.');

			return;
		}

		// ha kevesebb, vagy pont annyi várakozó van, mint a limit, akkor 1 meccsbe rakjuk őket
		else  if($waiting->count() <= $maxPlayers)
		{
			$this->createMatchWithUsers($waiting->pluck('user'));
		}

		// ha több várakozó van a maximálisnál, akkor csinálunk 1 fullos meccset, a többiek meg várnak
		else if($waiting->count() > $maxPlayers)
		{
			$this->createMatchWithUsers($waiting->pluck('user')->take($maxPlayers));
		}
	}

	/**
	 * @param Collection $users
	 */
	public function createMatchWithUsers(Collection $users)
	{
		$playerIds = [];
		// töröljük az embereket a queueból
		$users->each(function(User $user) use (&$playerIds){
			// $this->matchMakingRepository->removeUserFromQueue($user);
			$playerIds[] = ['id' => $user->id];
		});

		$pokerEngine = new PokerEngineAdapter();
		$game        = $pokerEngine->createGame($users);

		Current::truncate();

		foreach($users as $user)
		{
			$current = new Current();
			$current->user_id = $user->id;
			$current->save();
		}

		$this->startGame($game, $users);
	}

	/**
	 * @param Game       $game
	 * @param Collection $users
	 */
	public function startGame(Game $game, Collection $users)
	{
		// websocketre küldés
		foreach($users as $user)
		{
			broadcast(new GameHasCreated($game, $user));
		}

		// kiosztjuk a kártyákat
		foreach($game->getPlayers() as $player)
		{
			foreach($player->getHand() as $card)
			{
				foreach($users as $user)
				{
					broadcast(new DealCard($player->getId(), $card, $user->id));
				}
				sleep(1);
			}
		}
	}
}
