<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseCategory::insert([
            [
                'id' => 1,
                'name' => 'Engineering',
                'description' => 'Courses related to various engineering disciplines such as mechanical, electrical, civil, and software engineering.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Business & Management',
                'description' => 'Courses focused on finance, marketing, management, and entrepreneurship.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'IT & Artificial Intelligence',
                'description' => 'Subjects covering programming, data science, AI, and machine learning.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Environmental Science',
                'description' => 'Studies related to ecology, climate change, and sustainability.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Humanities & Social Sciences',
                'description' => 'Subjects exploring human culture, history, psychology, and sociology.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Ethics & Philosophy',
                'description' => 'Courses that discuss morality, ethics, logic, and philosophical thought.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Medical & Health Sciences',
                'description' => 'Courses covering medicine, nursing, pharmacy, and biomedical sciences.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Law & Political Science',
                'description' => 'Studies in law, governance, human rights, and political systems.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'Arts & Design',
                'description' => 'Courses in fine arts, graphic design, animation, and multimedia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
