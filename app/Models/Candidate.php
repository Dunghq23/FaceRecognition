<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $table = 'candidates'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'candidate_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'fk_origin_id',
        'fk_jobPost_id',
        'full_name',
        'email',
        'phone',
        'birthday',
        'gender',
        'address',
        'apply_time',
        'resumePath',
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
}
