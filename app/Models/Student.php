<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $appends = array('full_name_first_name', 'full_name_last_name');

    protected $fillable = [
        'student_id_number',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'gender_id',
        'guardian_id',
        'photo',
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

    public function getFullNameFirstNameAttribute()
    {
        return $this->first_name." ".$this->middle_name." ".$this->last_name." ".$this->ext_name;
    }
    public function getFullNameLastNameAttribute()
    {
        return $this->last_name.", ".$this->first_name." ".$this->middle_name." ".$this->ext_name;
    }


    public function gender()
    {
        return $this->belongsTo(Library::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getPhotoAttribute($value)
    {
        return Storage::url($value);
    }


}
