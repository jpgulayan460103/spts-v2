<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'library_type',
        'parent_id'
    ];

    public static function firstSemester()
    {
        $instance = new static;
        return $instance->where('library_type', 'semesters')->where('name', "First Semester")->first();
    }
    public static function secondSemester()
    {
        $instance = new static;
        return $instance->where('library_type', 'semesters')->where('name', "Second Semester")->first();
    }
    public static function firstQuarter()
    {
        $instance = new static;
        return $instance->where('library_type', 'quarters')->where('name', "First Quarter")->first();
    }
    public static function secondQuarter()
    {
        $instance = new static;
        return $instance->where('library_type', 'quarters')->where('name', "Second Quarter")->first();
    }
    public static function thirdQuarter()
    {
        $instance = new static;
        return $instance->where('library_type', 'quarters')->where('name', "Third Quarter")->first();
    }
    public static function fourthQuarter()
    {
        $instance = new static;
        return $instance->where('library_type', 'quarters')->where('name', "Fourth Quarter")->first();
    }
}
