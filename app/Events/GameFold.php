<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameFold implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string  */
    private $userId;

    /** @var array  */
    private $response;

    /**
     * Create a new event instance.
     *
     * @param string $userId
     * @param array  $response
     */
    public function __construct($userId, array $response)
    {
        $this->userId   = $userId;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.' . $this->userId);
    }

    public function broadcastAs() : string
    {
    	return 'poker';
    }

	/**
	 * @return array
	 */
    public function broadcastWith() : array
    {
    	return [
    		'event' => 'game.fold',
		    'data' => $this->response
	    ];
    }
}
