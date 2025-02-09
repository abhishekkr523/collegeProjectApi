<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'name', 'description'
    ];

    public $incrementing = false; // Because we're using UUID
    protected $keyType = 'string';

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_course_category', 'category_id', 'course_id');
    }
}
