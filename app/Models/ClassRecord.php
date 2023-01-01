<?php

namespace App\Models;

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
        });
        self::updating(function($model) {

        });
    }

    public function quarters()
    {
        return $this->hasMany(ClassRecordQuarter::class);
    }
}
