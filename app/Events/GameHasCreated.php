<?php

namespace App\Events;

use App\User;
use App\Entity\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameHasCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Game  */
    private $game;

    /** @var User  */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param Game $game
     * @param User $user
     */
    public function __construct(Game $game, User $user)
    {
	    $this->game = $game;
	    $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

	/**
	 * @return array
	 */
    public function broadcastWith()
    {
    	return [
    		'foo' => 'bar'
	    ];
    }

	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'game.created';
	}
}
