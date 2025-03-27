<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewSchedule extends Model
{
    use HasFactory;
    protected $table = 'interviewSchedules'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'interview_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'fk_jobPost_id',
        'fk_employee_id',
        'fk_candidate_id',
        'interview_time',
        'interview_location',
        'notes',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'fk_candidate_id', 'candidate_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'fk_employee_id', 'employee_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'fk_jobPost_id', 'jobPost_id');
    }
}
