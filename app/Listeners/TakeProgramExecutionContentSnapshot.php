<?php

namespace App\Listeners;

use App\Events\ExecutionFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TakeProgramExecutionContentSnapshot
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
     * @param  \App\Events\ExecutionFinished  $event
     * @return void
     */
    public function handle(ExecutionFinished $event)
    {
        //
    }
}
