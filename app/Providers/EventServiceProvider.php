<?php

namespace App\Providers;

use App\Events\EventTest;
use App\Listeners\ListenerTest;
use App\Listeners\UserEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        UserEventSubscriber::class
    ];
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
        // Manual event logging
        Event::listen(
            EventTest::class,
            [ListenerTest::class, 'handle']
        );

        // Anonymous event listeners in a queue
        Event::listen(queueable(function (EventTest $event){
            echo 'Event delay 10 sec.' . "\n";
            var_dump($event);
        })->delay(now()->addSeconds(10))->catch(function (EventTest $event, \Throwable $e){
            // error Event
            var_dump($event);
        }));

        // Anonymous event group listeners
        Event::listen('Event.*', function ($eventName, array $data){
            echo 'Event all -> Event.*' . "\n";
            var_dump($eventName, $data);
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
