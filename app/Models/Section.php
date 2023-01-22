<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'adviser_id',
        'school_year_id',
        'grade_level_id',
        'track_id',
    ];

    public function class_records()
    {
        return $this->hasMany(ClassRecord::class);
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
        self::updating(function($model) {

        });
    }
    public function school_year()
    {
        return $this->belongsTo(Library::class);
    }

    public function grade_level()
    {
        return $this->belongsTo(Library::class);
    }

    public function track()
    {
        return $this->belongsTo(Library::class);
    }

    public function students()
    {
        return $this->hasMany(SectionStudent::class);
    }
    public function adviser()
    {
        return $this->belongsTo(Teacher::class);
    }

}
