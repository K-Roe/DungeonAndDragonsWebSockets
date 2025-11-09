<?php

namespace App\Events;

use App\Entities\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class AdventureMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $user;
    public int $adventureId;

    public function __construct(User $user, string $message, int $adventureId)
    {
        $this->user = $user->getName();
        $this->message = $message;
        $this->adventureId = $adventureId;
    }

    public function broadcastOn(): Channel
    {

        return new PrivateChannel("adventure.{$this->adventureId}");
    }

    public function broadcastAs(): string
    {
        return 'AdventureMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user' => $this->user,
            'adventureId' => $this->adventureId,
        ];
    }
}
