<?php

namespace App\Listeners;

use App\Events\IssueEvent;
use App\Models\Timeline;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordLogToTimeline
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
    public function handle(IssueEvent $event): void
    {
        Timeline::create([
            'issue_id' => $event->issue_id,
            'event' => $event->log,
        ]);
    }
}
