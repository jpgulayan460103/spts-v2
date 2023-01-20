<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClassRecordQuarter extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_record_id',
        'quarter_id',
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

    public function quarter()
    {
        return $this->belongsTo(Library::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
