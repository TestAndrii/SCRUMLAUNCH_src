<?php

namespace App\Providers;

use App\Events\EventTest;
use App\Listeners\ListenerTest;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        EventTest::class => [
            ListenerTest::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        Event::listen(
            EventTest::class,
            [ListenerTest::class, 'handle']
        );

        Event::listen(queueable(function (EventTest $event){
            echo "Event delay 10 sec.";
        })->delay(now()->addSeconds(10)));

        Event::listen('event.*', function ($eventName, array $data){
            echo "Event all -> event.*";
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

}
