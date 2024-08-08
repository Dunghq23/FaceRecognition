<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'employee_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'employee_name',
        'fk_department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'fk_department_id', 'department_id');
    }

    public function timekeepings()
    {
        return $this->hasMany(Timekeeping::class, 'fk_employee_id');
    }
}
