<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IssuedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
       {
    $students = DB::table('students')->pluck('id')->toArray();
    $books = DB::table('books')->pluck('id')->toArray();
    $statuses = ['pending', 'returned'];

    // Generate all possible unique student-book pairs
    $combinations = [];

    foreach ($students as $studentId) {
        foreach ($books as $bookId) {
            $combinations[] = [
                'student_id' => $studentId,
                'book_id' => $bookId,
            ];
        }
    }

    shuffle($combinations); // Randomize order

    // Limit the total entries to max 150 or available combinations
    $entries = min(59, count($combinations));
       // Define the date range for attendance
        $startDate = Carbon::create('2018', '01', '01'); // Starting date: 2024-01-01
        $endDate = Carbon::create('2024', '12', '31'); 
    for ($i = 0; $i < $entries; $i++) {
        $combo = $combinations[$i];
        $issueDate =  Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
        $returnDate = (clone $issueDate)->addDays(rand(7, 30));
        $status = $statuses[array_rand($statuses)];
        $fine = $status === 'pending' ? '50Rs' : '0 Rs';

        DB::table('issue_books')->insert([
            'id' => Str::uuid(),
            'book_id' => $combo['book_id'],
            'student_id' => $combo['student_id'],
            'issue_date' => $issueDate->toDateString(),
            'return_date' => $returnDate->toDateString(),
            'status' => $status,
            'fine' => $fine,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}
