<?php

namespace Database\Seeders;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            [   'id' => 1,
                'name' => 'Computer Science',
                'description' => 'Study of computers and computational systems.',
                'category_id' => 1,
                'duration' => 48, // months
                'instructor' => 'Dr. John Smith',
                'credits' => 6,
                'fee' => 30000.00,
                'start_date' => '2024-06-01',
                'end_date' => '2028-05-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 2,
                'name' => 'Digital Marketing',
                'description' => 'Introduction to online marketing strategies.',
                'category_id' => 2,
                'duration' => 6, // months
                'instructor' => 'Ms. Emma Brown',
                'credits' => 3,
                'fee' => 10000.00,
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 3,
                'name' => 'Data Science',
                'description' => 'Study of data analysis and machine learning.',
                'category_id' => 3,
                'duration' => 48, // months
                'instructor' => 'Prof. Mark Lee',
                'credits' => 4,
                'fee' => 30000.00,
                'start_date' => '2024-09-01',
                'end_date' => '2025-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
