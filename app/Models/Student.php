<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'name',
        'roll_no',
        'phone',
        'branch',
        'session',
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'student_semester', 'student_id', 'semester_id') ->withTimestamps();
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id','subject_id');
    }
    // Automatically assign all 8 semesters to a newly created student
    protected static function boot()
    {
        parent::boot();

        static::created(function ($student) {
            // Fetch all semester IDs
            $semesterIds = Semester::pluck('id')->toArray();

            // Attach all semesters to the student
            $student->semesters()->attach($semesterIds);
        });
    }
}
