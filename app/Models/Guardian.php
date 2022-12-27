<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_id_number',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'contact_number',
        'gender_id',
    ];
}
