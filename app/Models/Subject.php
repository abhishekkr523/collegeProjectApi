<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'name', 'code', 'credits'];

    // A subject belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'semester_subject', 'subject_id', 'semester_id');
    }
}
