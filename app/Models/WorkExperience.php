<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;
    protected $table = 'workExperiences'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'workExperience_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'fk_candidate_id',
        'workplace',
        'work_description',
        'time_start',
        'time_end',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'fk_candidate_id', 'candidate_id');
    }
}
