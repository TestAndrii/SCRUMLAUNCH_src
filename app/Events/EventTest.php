<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventTest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $name;

    /**
     * Create a new event instance.
     *
     * @param String $name
     */
    public function __construct(String $name)
    {
        $this->name = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        return [];
//        return new PrivateChannel('channel-name');
    }
}
