<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'name', 'description', 'duration', 'instructor', 'credits', 'fee', 'start_date', 'end_date'
    ];

    public $incrementing = false; // Because we're using UUID
    protected $keyType = 'string';

    public function categories()
    {
        return $this->belongsToMany(CourseCategory::class, 'course_course_category', 'course_id', 'category_id');
    }
}
