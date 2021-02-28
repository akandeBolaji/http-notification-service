<?php

namespace App\Listeners;

use App\Events\MessagePublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Subscription;
use App\Jobs\NotifySubscriber;

class NotifySubscribers implements ShouldQueue
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
     * @param  MessagePublished  $event
     * @return void
     */
    public function handle(MessagePublished $event)
    {
        $subscriptions = $event->topic->subscriptions;

        foreach ($subscriptions as $subscription) {
            dispatch(new NotifySubscriber($subscription->url, $event->message));
        }
    }
}
