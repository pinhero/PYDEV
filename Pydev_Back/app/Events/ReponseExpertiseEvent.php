<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReponseExpertiseEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $description;
    public $expert_id;
    public $expertise_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $description,int $expert_id,int $expertise_id)
    {
        $this->description = $description;
        $this->expert_id = $expert_id;
        $this->expertise_id = $expertise_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('expertise-').$this->expertise_id;
    }

    public function broadcastAs()
    {
        return 'reponse-expertise';
    }
}
