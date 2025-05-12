<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudentAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $students = DB::table('students')->pluck('id');
        $semesters = DB::table('semesters')->pluck('id');
        $subjects = DB::table('subjects')->pluck('id');
        $statuses = ['present', 'absent', 'late'];
        $maxEntries = 150;
        $entryCount = 0;
        // Define the date range for attendance
        $startDate = Carbon::create('2018', '01', '01'); // Starting date: 2024-01-01
        $endDate = Carbon::create('2024', '12', '31');   // Ending date: 2024-12-31

        foreach ($students as $studentId) {
            if ($entryCount >= $maxEntries) break;
  $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            DB::table('attendances')->insert([
                'id' => Str::uuid(),
                'student_id' => $studentId,
                'semester_id' => $semesters->random(),
                'subject_id' => $subjects->random(),
                'attendance_status' => $statuses[array_rand($statuses)],
                'date' => $randomDate->toDateString(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $entryCount++;
        }
    
}
}
