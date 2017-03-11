<?php

namespace App\MatchMaking\Model;

use App\MatchMakingQueue;
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
		$minPlayers = 2;
		$maxPlayers = 8;
		$waiting = $this->matchMakingRepository->allWaitingPlayers();

		// ha kevesebb, vagy pont annyi várakozó van, mint a limit, akkor 1 meccsbe rakjuk őket
		if($waiting->count() <= $minPlayers)
		{
			logger()->info('Nincs elég ember party készítéshez. Várakozunk.');
		}
		if($waiting->count() <= $maxPlayers)
		{
			$this->createMatchWithUsers($waiting->pluck('user'));
		}
		else if($waiting->count() > $maxPlayers)
		{
			$this->createMatchWithUsers($waiting->take($maxPlayers));
		}
	}

	/**
	 * @param Collection $users
	 */
	public function createMatchWithUsers(Collection $users)
	{
		// töröljük az embereket a queueból
		$users->each(function(User $user){
			$this->matchMakingRepository->removeUserFromQueue($user);
		});


		// create a match
		// call poker service
		// assign players

	}
}