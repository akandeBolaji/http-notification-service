<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Topic;

class MessagePublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The topic instance.
     *
     * @var \App\Models\Topic
     */
    public $topic;

    /**
     * The message instance.
     *
     */
    public $message;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Topic $topic, $message)
    {
        $this->topic = $topic;
        $this->message = $message;
    }
}
