<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_description',
        'track_id',
        'semester_id',
        'grade_level_id',
        'offer_code',
        'subject_code',
    ];
}
