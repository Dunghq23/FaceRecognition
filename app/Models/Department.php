<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'department_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'department_name',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'fk_department_id', 'department_id');
    }
}
