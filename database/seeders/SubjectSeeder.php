<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::insert([
            // Subjects for Computer Science (Course ID: 1)
            ['id' => 1,
                'name' => 'Data Structures',
                'description' => 'Introduction to data structures like arrays, linked lists, trees, and graphs.',
                'course_id' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 2,
                'name' => 'Compiler Design',
                'description' => 'Study of OS concepts, process management, and memory allocation.',
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' =>3,
                'name' => 'DBMS',
                'description' => 'Study of OS concepts, process management, and memory allocation.',
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 4,
                'name' => 'OOPs',
                'description' => 'Study of OS concepts, process management, and memory allocation.',
                'course_id' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Subjects for Digital Marketing (Course ID: 2)
            ['id' => 5,
                'name' => 'SEO Optimization',
                'description' => 'Understanding search engine optimization techniques.',
                'course_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' => 6,
                'name' => 'Content Marketing',
                'description' => 'Learning to create engaging and effective content.',
                'course_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Subjects for Data Science (Course ID: 3)
            ['id' => 7,
                'name' => 'Machine Learning',
                'description' => 'Introduction to ML algorithms and data modeling.',
                'course_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id' =>8,
                'name' => 'Big Data Analytics',
                'description' => 'Techniques for analyzing large datasets and predictive modeling.',
                'course_id' =>3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
