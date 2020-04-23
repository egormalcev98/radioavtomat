<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $messageData; //Данные сообщения, которые отправим на фронт
	
	private $authUserId;
	private $messageCollect; //Собственно коллекция сообщения для манипуляций
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($messageData, $authUserId, $messageCollect)
    {
        $this->messageData = $messageData;
        $this->authUserId = $authUserId;
        $this->messageCollect = $messageCollect;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
		if($this->messageCollect->to_user_id) {
			$arrChannelId = [$this->messageCollect->to_user_id, $this->authUserId];
			sort($arrChannelId);
			$channelId = implode('.', $arrChannelId);
		}
		
        return new PrivateChannel('chat-user.' . $channelId);
    }
	
	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'newMessage';
	}
}
