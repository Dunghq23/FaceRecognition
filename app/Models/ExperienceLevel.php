<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceLevel extends Model
{
    use HasFactory;
    protected $table = 'experienceLevels'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'level_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'level_name',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'fk_level_id', 'level_id');
    }
}
