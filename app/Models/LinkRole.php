<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkRole extends Model
{
    use HasFactory;
    protected $table = 'linkRoles';

    protected $fillable = [
        'fk_employee_id',
        'fk_role_id',
    ];
}
