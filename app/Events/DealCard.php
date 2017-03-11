<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DealCard implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	private $userId;
	private $cardName;

	/**
     * Create a new event instance.
     *
	 * @param string $userId
	 * @param string $cardName
     */
    public function __construct($userId, $cardName)
    {
	    $this->userId = $userId;
	    $this->cardName = $cardName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

	/**
	 * @return array
	 */
	public function broadcastWith()
	{
		return [
			'card' => $this->cardName
		];
	}

	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'deal.card';
	}
}
