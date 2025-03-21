<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticableTrait;

    protected $table = 'accounts';

    protected $primaryKey = 'account_id';

    protected $fillable = [
        'fk_employee_id',
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'fk_employee_id', 'employee_id');
    }
}
