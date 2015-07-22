<?php

namespace App\Listeners;

use App\Events\BookIsAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendEmail;
use App\User;

class BookIsAddedListener
{

    use DispatchesJobs;
    
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
     * @param  Events  $event
     * @return void
     */
    public function handle(BookIsAdded $event)
    {
        $users = User::all();

        foreach($users as $user) {
            $this->dispatch(new SendEmail($event->book, $user));
        }
    }
}
