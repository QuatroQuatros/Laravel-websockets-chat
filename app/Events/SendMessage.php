<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Message;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $toUser;

   
    public function __construct(
        Message $message,
        int $toUser
    )
    {
        $this->message = $message;
        $this->toUser = $toUser;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->toUser),
        ];
    }

    public function broadcastAs(): string
    {
        return 'SendMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message
        ];
    }
}
