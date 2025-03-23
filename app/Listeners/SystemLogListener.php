<?php

namespace App\Listeners;

use App\Events\SystemLogEvent;
use App\Models\SystemLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SystemLogListener implements ShouldQueue
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
    public function handle(SystemLogEvent $event): void
    {
        //
        SystemLog::create([
            'fk_account_id' => $event->fk_account_id,
            'action' => $event->action,
            'table_name' => $event->table,
            'record_id' => $event->record_id,
            'details' => $event->details,
            'user_agent' => $event->agent,
            'created_at' => now(),
        ]);
    }
}
