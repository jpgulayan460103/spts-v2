<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingScale extends Model
{
    use HasFactory;

    protected $fillable = [
        'transmuted_grade',
        'descriptor',
        'remarks',
    ];
}