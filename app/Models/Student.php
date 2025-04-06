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
        return $this->belongsToMany(Semester::class, 'student_semester', 'student_id', 'semester_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
