<?php

namespace App\Listeners;

use App\Events\HomeworkStarted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TakeHomeworkSnapshot
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
     * @param  \App\Events\HomeworkStarted  $event
     * @return void
     */
    public function handle(HomeworkStarted $event)
    {
        //
    }
}
