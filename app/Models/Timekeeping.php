<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timekeeping extends Model
{
    use HasFactory;
    protected $table = 'timekeeping'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'timekeeping_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'fk_employee_id',
        'check_in',
        'check_out'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'fk_employee_id');
    }
}
