<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleParent extends Model
{
    use HasFactory;
    protected $table = 'roleParents';
    protected $primaryKey = 'roleParent_id';
    protected $fillable = [
        'roleParent_name',
    ];

    /**
     * Quan hệ 1-N: Một RoleParent có nhiều Roles
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'fk_roleParent_id', 'roleParent_id');
    }
}
