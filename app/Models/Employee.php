<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'employee_id'; // Khóa chính của bảng

    public $timestamps = false; // Vì đã có `created_at` và `updated_at` nên bạn đã tắt timestamps mặc định

    protected $fillable = [
        'employee_username',
        'employee_name',
        'email',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'position',
        'fk_department_id',
        'start_date',
        'salary',
        'employment_status',
        'profile_picture',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'date_of_birth',
        'start_date',
        'created_at',
        'updated_at'
    ];

    // Định nghĩa mối quan hệ với bảng departments
    public function department()
    {
        return $this->belongsTo(Department::class, 'fk_department_id', 'department_id');
    }

    // Định nghĩa mối quan hệ với bảng timekeepings
    public function timekeepings()
    {
        return $this->hasMany(Timekeeping::class, 'fk_employee_id');
    }
}
