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
}
