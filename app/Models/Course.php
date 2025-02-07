<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category', 'duration', 'instructor', 'credits', 'fee', 'start_date', 'end_date'];

    // A course has many subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
