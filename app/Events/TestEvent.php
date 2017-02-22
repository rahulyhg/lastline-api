<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string  */
    private $name;

    /** @var array */
    private $data;

    /**
     * Create a new event instance.
     *
     * @param string $name
     * @param array  $data
     */
    public function __construct($name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return $this->name;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['data' => $this->data];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('test-channel');
    }
}
