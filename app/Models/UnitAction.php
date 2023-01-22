<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_feedback',
        'unit_id',
        'action_id',
        'section_student_id',
    ];

    public function action()
    {
        return $this->belongsTo(Library::class);
    }

}
