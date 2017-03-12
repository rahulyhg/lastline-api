<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DealCard implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	private $userId;
	private $cardName;
	private $targetId;

	/**
     * Create a new event instance.
     *
	 * @param string $userId
	 * @param string $cardName
	 * @param string $targetId
     */
    public function __construct($userId, $cardName, $targetId)
    {
	    $this->userId   = $userId;
	    $this->cardName = $cardName;
	    $this->targetId = $targetId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.' . $this->targetId);
    }

	/**
	 * @return array
	 */
	public function broadcastWith()
	{
		if($this->userId !== $this->targetId)
		{
			$this->cardName = 'back';
		}

		return [
			'action' => 'deal.card',
			'data' => [
				'card'   => $this->cardName,
				'userId' => $this->userId
			]
		];
	}

	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'poker';
	}
}
