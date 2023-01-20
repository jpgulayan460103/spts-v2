<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UnitItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'unit_id',
        'grading_system_id',
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

    public function grading_system()
    {
        return $this->belongsTo(GradingSystem::class);
    }
}
