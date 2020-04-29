<?php

namespace App\Events\IncDocUsers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\IncomingDocuments\IncomingDocumentUser;

class IncDocUserNotifications
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $incomingDocumentUser;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(IncomingDocumentUser $incomingDocumentUser)
    {
        $this->incomingDocumentUser = $incomingDocumentUser;
    }

}
