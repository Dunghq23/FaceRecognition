<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;
    protected $table = 'majors'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'major_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'major_name',
    ];
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'fk_major_id', 'major_id');
    }
}
