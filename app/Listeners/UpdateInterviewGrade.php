<?php

namespace App\Listeners;

use App\Events\InterviewFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInterviewGrade
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
     * @param  \App\Events\InterviewFinished  $event
     * @return void
     */
    public function handle(InterviewFinished $event)
    {
        //
    }
}
