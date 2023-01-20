<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_description',
        'track_id',
        'semester_id',
        'grade_level_id',
        'subject_category_id',
        'offer_code',
        'subject_code',
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

    public function track()
    {
        return $this->belongsTo(Library::class);
    }
    
    public function semester()
    {
        return $this->belongsTo(Library::class);
    }
    
    public function grade_level()
    {
        return $this->belongsTo(Library::class);
    }
    
    public function subject_category()
    {
        return $this->belongsTo(Library::class);
    }
    
}
