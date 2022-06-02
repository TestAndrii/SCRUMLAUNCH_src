<?php

namespace App\Listeners;

use App\Events\EventTest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TelegramNotification;

class ListenerTest
{
    protected string $nameEvent;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EventTest $event
     * @return void
     */
    public function handle(EventTest $event): void
    {
        $this->nameEvent = $event->name;

        $message = $this->nameEvent . "\n" . 'EventTest sent to the queue. ' . now();
        $notifiable = config('services.telegram-bot-api.bot_id');

        // Send notification
        Notification::send($notifiable, new TelegramNotification($message) );

        echo "<br>New Events added in database with name: " . $this->nameEvent;
        echo "<br>" . $message . "<br>";

    }
}
