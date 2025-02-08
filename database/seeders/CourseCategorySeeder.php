<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Support\Str;
use App\Models\SubjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseCategory::insert([
            ['id' => 1,
                'name'        => 'Engineering',
                'description' => 'Subjects related to natural and physical sciences.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            ['id' => 2,
                'name'        => 'Business',
                'description' => 'Subjects that deal with numbers, equations, and calculations.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            ['id' => 3,
                'name'        => 'IT & AI',
                'description' => 'Subjects that explore human culture, history, and art.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            // Add more categories as needed...
        ]);
    }
}
