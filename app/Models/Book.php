<?php

namespace App\Models;

use App\Models\Admin\IssueBook;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasUuids;

    // Specify the table associated with the model (optional if table follows Laravel's convention)
    protected $table = 'books';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'number_of_pages',
        'status',
    ];

    // Define the data types for the model attributes (optional)
    protected $casts = [
        'publication_year' => 'integer',
        'number_of_pages' => 'integer',
    ];
    public function issues()
    {
        return $this->belongsToMany(IssueBook::class, 'book_id');
    }
    public function students()
{
    return $this->belongsToMany(
        Student::class,
        'student_id'      // Foreign key in the pivot table referring to the related model
    )->withTimestamps();
}
    // Define relationships (if any, for example, a Book can belong to a Library or Category)

    // For example, if you want to add a relationship to a `Category` model
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}

