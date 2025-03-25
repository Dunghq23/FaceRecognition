<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;
    protected $table = 'systemLogs';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
    protected $fillable = [
        'fk_account_id',
        'action',
        'table_name',
        'record_id',
        'details',
        'user_agent'
    ];

    public function getTime()
    {
        return $this->created_at ? (new DateTime($this->created_at))->format('H:i:s d/m/Y') : null;
    }

    public function account()
    {
        return $this->belongsTo(User::class, 'fk_account_id');
    }
}
