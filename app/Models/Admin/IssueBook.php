<?php

namespace App\Models\Admin;

use App\Models\Book;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class IssueBook extends Model
{
    protected $fillable = [
        'id',
        'book_id',
        'student_id',
        'issue_date',
        'return_date',
        'fine',
    ];

    public function book()
{
    return $this->belongsTo(Book::class, 'book_id');
}
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // If the id isn't already set, generate a UUID
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
