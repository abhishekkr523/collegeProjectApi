<?php

namespace App\Models;

use App\Models\Admin\IssueBook;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory;
    use HasUuids;
    use Notifiable;
    protected $fillable = [
        'name',
        'roll_no',
        'phone',
        'branch',
        'session',
        'email',
    ];
    public function routeNotificationForMail($notification)
    {
        return $this->email; // Ensure 'email' column exists in your students table
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function issueBooks()
    {
        return $this->hasMany(IssueBook::class, 'student_id');
    }
    public function books()
{
    return $this->belongsToMany(
        Book::class,
        'book_student',   // Pivot table name
        'student_id',     // Foreign key in the pivot table referring to this model
        'book_id'         // Foreign key referring to the Book model
    )->withTimestamps();
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
    public function user()
{
    return $this->hasOneThrough(User::class, UserStudent::class, 'student_id', 'id', 'id', 'user_id');
}

}
