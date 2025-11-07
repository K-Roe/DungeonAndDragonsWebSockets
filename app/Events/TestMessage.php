<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $message = 'Hello from Laravel 👋'
    ) {}

    public function broadcastOn(): Channel
    {
        // this defines the channel name
        return new Channel('test');
    }

    public function broadcastAs(): string
    {
        // this defines the event name your frontend listens for
        return 'message.sent';
    }
}
