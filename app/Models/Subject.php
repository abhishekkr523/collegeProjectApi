<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'course_id'];

    // A subject belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
