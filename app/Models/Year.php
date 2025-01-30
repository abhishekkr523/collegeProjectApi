<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'id',          // UUID primary key
        'year_name',   // Name of the academic year
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class, 'year_id');
    }
}
