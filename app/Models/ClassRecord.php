<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClassRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_record_number',
        'section_id',
        'subject_id',
        'teacher_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
            // $model->class_record_number = Carbon::now()->format("Y-").str_pad($model->id, 5, "0");
        });
        self::updating(function($model) {

        });
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function quarters()
    {
        return $this->hasMany(ClassRecordQuarter::class);
    }
}
