<?php

namespace App\Models\Admin;

use App\Models\Book;
use App\Models\Student;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class IssueBook extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'book_id',
        'student_id',
        'issue_date',
        'return_date',
        'fine',
        'status',
    ];

    public function book()
{
    return $this->belongsTo(Book::class, 'book_id');
}
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
