<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;
    protected $table = 'system_logs';
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

    public function account()
    {
        return $this->belongsTo(User::class, 'fk_account_id');
    }
}
