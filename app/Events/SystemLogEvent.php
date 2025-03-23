<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemLogEvent
{
    use Dispatchable, SerializesModels;

    public $fk_account_id, $action, $table, $record_id, $details, $ip, $agent;

    public function __construct($action, $table = null, $record_id = null, $details = null)
    {
        $this->fk_account_id = auth()->id();
        $this->action = $action;
        $this->table = $table;
        $this->record_id = $record_id;
        $this->details = $details ? json_encode($details) : null;
        $this->ip = request()->ip();
        $this->agent = request()->header('User-Agent');
    }
}
