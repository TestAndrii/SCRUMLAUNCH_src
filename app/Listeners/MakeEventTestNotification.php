<?php

namespace App\Listeners;

use App\Events\EventTest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TelegramNotification;

class MakeEventTestNotification
{
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
     * @param  \App\Events\EventTest  $event
     * @return void
     */
    public function handle(EventTest $event): void
    {
        $message = 'EventTest sent to the queue. '. now()->format('u') . ' mks.';
        $notifiable = config('services.telegram-bot-api.bot_id');

        Notification::send($notifiable, new TelegramNotification($message) );

        echo "<br>MakeEventTestNotification Listeners - " . get_class() . " = " . now()->format('u') . ' mks.';

    }
}
