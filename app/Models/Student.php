<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id_number',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'gender_id',
        'guardian_id',
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


    public function gender()
    {
        return $this->belongsTo(Library::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

}
