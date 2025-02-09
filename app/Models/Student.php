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
        return $this->belongsToMany(Semester::class, 'student_semester', 'student_id', 'semester_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
