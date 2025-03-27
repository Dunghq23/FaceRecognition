<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateOrigin extends Model
{
    use HasFactory;
    protected $table = 'candidateOrigins'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'origin_id'; // Khóa chính của bảng

    public $timestamps = false;

    protected $fillable = [
        'origin_name',
    ];
}
