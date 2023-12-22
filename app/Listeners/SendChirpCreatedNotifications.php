<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewChirp;
use App\Events\ChirpCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreatedEvent $event): void
    {
        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {

            $user->notify(new NewChirp($event->chirp));

        }
    }
}