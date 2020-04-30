<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
		\App\Events\Chat\NewMessage::class => [
			
		],
		\App\Events\Chat\NotifyNewMessage::class => [
			
		],
		\App\Events\Chat\UpdateCountNewMessages::class => [
			
		],
		\App\Events\Notifications\UpdateBellNotifications::class => [
			
		],
		\App\Events\IncDocUsers\IncDocUserNotifications::class => [
			\App\Events\IncDocUsers\Listeners\Notify::class,
		],
		\App\Events\Tasks\TaskNotifications::class => [
			\App\Events\Tasks\Listeners\Notify::class,
		],
		\App\Events\Notes\NoteNotifications::class => [
			\App\Events\Notes\Listeners\Notify::class,
		],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
