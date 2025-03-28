<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;
    protected $table = 'jobPosts'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'jobPost_id'; // Khóa chính của bảng

    // public $timestamps = false;

    protected $fillable = [
        'fk_level_id',
        'fk_jobType_id',
        'fk_major_id',
        'fk_employee_id',
        'title',
        'role_hire',
        'work_place',
        'salary_range',
        'quantity_hire',
        'expiried_date',
        'description',
        'requirement',
        'benefits',
        'status'
    ];

    // Relationship with ExperienceLevel
    public function experienceLevel()
    {
        return $this->belongsTo(ExperienceLevel::class, 'fk_level_id', 'level_id');
    }

    // Relationship with JobType
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'fk_jobType_id', 'jobType_id');
    }

    // Relationship with Major
    public function major()
    {
        return $this->belongsTo(Major::class, 'fk_major_id', 'major_id');
    }

    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'fk_employee_id', 'employee_id');
    }

    // Relationship with Candidate
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'fk_jobPost_id', 'jobPost_id');
    }

    public function getFormattedExpiriedDateAttribute()
    {
        return Carbon::parse($this->expiried_date)->format('d/m/Y');
    }

    public function getInterviewerPendingAttribute()
    {
        return $this->candidates()->where('status', 0)->count();
    }

    public function getInterviewingAttribute()
    {
        return $this->candidates()->where('status', 1)->count();
    }

    public function getInterviewerPassedAttribute()
    {
        return $this->candidates()->where('status', 2)->count();
    }

    public function getInterviewerFailedAttribute()
    {
        return $this->candidates()->where('status', 3)->count();
    }
}
