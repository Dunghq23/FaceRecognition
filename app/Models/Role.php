<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_name',
        'fk_roleParent_id',
    ];

    /**
     * Quan hệ N-1: Một Role thuộc về một RoleParent
     */
    public function roleParent()
    {
        return $this->belongsTo(RoleParent::class, 'fk_roleParent_id', 'roleParent_id');
    }
    
    /**
     * Quan hệ N-N: Một Role có thể được gán cho nhiều Employees
     */
    public function accounts()
    {
        return $this->belongsToMany(User::class, 'linkRoles', 'fk_role_id', 'fk_account_id');
    }
}
