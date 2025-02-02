<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class YearAndSemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert into years table
        DB::table('years')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'year_name' => 'First',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('years')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'year_name' => 'Second',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('years')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'year_name' => 'Third',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('years')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'year_name' => 'Forth',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert into semesters table
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'First',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Second',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Third',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Forth',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Fifth',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Sixth',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Seventh',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('semesters')->insert([
            'id' => Str::uuid(), // Generate a unique UUID
            'semester_name' => 'Eight',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Year and Semester entries created successfully!');
    }
}
