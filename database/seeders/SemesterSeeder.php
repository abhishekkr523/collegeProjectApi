<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            'Semester-1',
            'Semester-2',
            'Semester-3',
            'Semester-4',
            'Semester-5',
            'Semester-6',
            'Semester-7',
            'Semester-8',
        ];

        $data = [];
        foreach ($semesters as $semester) {
            $data[] = [
                'id'            => Str::uuid(),
                'semester_name' => $semester,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        DB::table('semesters')->insert($data);
    }
}
