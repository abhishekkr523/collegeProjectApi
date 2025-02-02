<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Insert a few student records into the 'students' table
        Student::create([
            'id' => Str::uuid(),
            'name' => 'John Doe',
            'roll_no' => '12345',
            'phone' => '555-1234',
            'branch' => 'Computer Science',
            'session' => '2021-2025',
        ]);

        Student::create([
            'id' => Str::uuid(),
            'name' => 'Jane Smith',
            'roll_no' => '12346',
            'phone' => '555-5678',
            'branch' => 'Electrical Engineering',
            'session' => '2022-2026',
        ]);

        Student::create([
            'id' =>  Str::uuid(),
            'name' => 'Alice Johnson',
            'roll_no' => '12347',
            'phone' => '555-9101',
            'branch' => 'Mechanical Engineering',
            'session' => '2023-2027',
        ]);
    }
}
