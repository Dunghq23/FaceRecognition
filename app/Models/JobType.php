<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;
    protected $table = 'jobTypes'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'jobType_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'jobType_name',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'fk_jobType_id', 'jobType_id');
    }
}
