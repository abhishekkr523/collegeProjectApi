<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'id',              // UUID primary key
        'semester_name',   // Name of the semester
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class, 'sem_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_semester', 'semester_id', 'student_id')->withTimestamps();;
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
      public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'semester_subject', 'semester_id', 'subject_id')->withTimestamps();
    }

}
