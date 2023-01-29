<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'attendance_id',
        'section_student_id',
        'present_days',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    public function section_student()
    {
        return $this->belongsTo(SectionStudent::class);
    }
}
