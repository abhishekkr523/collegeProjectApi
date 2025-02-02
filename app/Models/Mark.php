<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'subject',           // Subject name
        'total_marks',       // Total marks for the subject
        'midterm_marks',     // Marks scored in midterm exams
        'assignment_marks',  // Marks scored in assignments
        'student_id',        // Foreign key linking to students
        'year_id',           // Foreign key linking to years
        'sem_id',            // Foreign key linking to semesters
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class,'year_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'sem_id');
    }
}
