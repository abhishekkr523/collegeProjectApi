<?php

namespace App\Models;

use App\Models\Admin\IssueBook;
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


}
