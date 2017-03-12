<?php

namespace App\MatchMaking\Repository;

use App\User;
use App\MatchMakingQueue;

class MatchMakingRepository
{
	/**
	 * Hozzááadja a $user-t a matchmaking queue-hoz.
	 *
	 * @param User $user
	 *
	 * @return MatchMakingQueue
	 */
	public function addUserToQueue(User $user) : MatchMakingQueue
	{
		$model = new MatchMakingQueue();
		$model->user_id = $user->id;
		$model->save();

		return $model;
	}

	/**
	 * Kitörli a usert a queueból.
	 *
	 * @param User $user
	 *
	 * @return bool Történt-e törlés
	 */
	public function removeUserFromQueue(User $user): bool
	{
		$result = MatchMakingQueue::where('user_id', $user->id)->delete();

		return $result > 0;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function allWaitingPlayers()
	{
		return MatchMakingQueue::with('user')->latest()->take(5)->get();
	}
}