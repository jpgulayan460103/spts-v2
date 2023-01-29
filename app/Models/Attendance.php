<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_record_id',
        'week_name',
        'total_days',
    ];

    public function class_record()
    {
        return $this->belongsTo(ClassRecord::class);
    }
}
