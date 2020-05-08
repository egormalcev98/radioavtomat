<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyNewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data; //Данные, которые отправим на фронт
	
	private $idUsers;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $idUsers)
    {
        $this->data = $data;
        $this->idUsers = $idUsers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
		$channels = [];
		
        foreach ($this->idUsers as $id) {
            $channels[] = new PrivateChannel('user.' . $id);
        }
		
        return $channels;
    }
	
	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith()
	{
		return $this->data;
	}
	
	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'notifyNewMessage';
	}
}
