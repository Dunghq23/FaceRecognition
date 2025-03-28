<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $table = 'candidates'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'candidate_id'; // Khóa chính của bảng

    // public $timestamps = false;

    protected $fillable = [
        'fk_origin_id',
        'fk_jobPost_id',
        'full_name',
        'email',
        'phone',
        'birthday',
        'gender',
        'address',
        'education_level', 
        'education_place',
        'major',
        'apply_time',
        'resumePath',
        'avt',
        'status'
    ];

    public function origin()
    {
        return $this->belongsTo(CandidateOrigin::class, 'fk_origin_id', 'origin_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'fk_jobPost_id', 'jobPost_id');
    }

    public function getApplyTimeAttribute()
    {
        return Carbon::parse($this->apply_time)->format('d/m/Y');
    }
}
