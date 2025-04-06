<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                'id' => 1,
                'name' => 'Computer Science',
                'description' => 'Study of computers and computational systems.',
                'duration' => 48, // months
                'instructor' => 'Dr. John Smith',
                'credits' => 6,
                'fee' => 30000.00,
                'start_date' => '2024-06-01',
                'end_date' => '2028-05-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Digital Marketing',
                'description' => 'Introduction to online marketing strategies.',
                'duration' => 6, // months
                'instructor' => 'Ms. Emma Brown',
                'credits' => 3,
                'fee' => 10000.00,
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Data Science',
                'description' => 'Study of data analysis and machine learning.',
                'duration' => 48, // months
                'instructor' => 'Prof. Mark Lee',
                'credits' => 4,
                'fee' => 30000.00,
                'start_date' => '2024-09-01',
                'end_date' => '2025-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Artificial Intelligence',
                'description' => 'Fundamentals of AI and machine learning.',
            
                'duration' => 36, // months
                'instructor' => 'Dr. Alan Turing',
                'credits' => 5,
                'fee' => 28000.00,
                'start_date' => '2024-08-01',
                'end_date' => '2027-07-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Business Administration',
                'description' => 'Management and leadership in business.',
           
                'duration' => 24, // months
                'instructor' => 'Dr. Susan Carter',
                'credits' => 4,
                'fee' => 25000.00,
                'start_date' => '2024-10-01',
                'end_date' => '2026-09-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Cyber Security',
                'description' => 'Learn about ethical hacking and security systems.',
           
                'duration' => 18, // months
                'instructor' => 'Mr. James Donovan',
                'credits' => 5,
                'fee' => 22000.00,
                'start_date' => '2025-01-15',
                'end_date' => '2026-07-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Graphic Design',
                'description' => 'Creative design techniques using modern tools.',
            
                'duration' => 12, // months
                'instructor' => 'Ms. Rachel Green',
                'credits' => 3,
                'fee' => 15000.00,
                'start_date' => '2025-03-01',
                'end_date' => '2026-02-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Software Engineering',
                'description' => 'Advanced software development methodologies.',
           
                'duration' => 48, // months
                'instructor' => 'Dr. Robert Lang',
                'credits' => 6,
                'fee' => 32000.00,
                'start_date' => '2024-05-01',
                'end_date' => '2028-04-30',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
