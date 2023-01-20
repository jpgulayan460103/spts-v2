<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'unit_id',
        'unit_item_id',
        'section_student_id',
        'grading_system_id',
    ];
}
