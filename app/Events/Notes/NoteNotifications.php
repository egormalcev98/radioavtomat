<?php

namespace App\Events\Notes;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notes\Note;

class NoteNotifications
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $note;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
