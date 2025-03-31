<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $title;
    public $body;
    public $actionUrl;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $title, $body, $actionUrl = null)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel[]
     */
    public function broadcastOn(): array
    {
        // Broadcasting to a private user channel
        return [new Channel('user.' . $this->userId)];
    }

    /**
     * Customize the event name
     */
    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}
