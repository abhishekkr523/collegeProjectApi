<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notices')->insert([
            [
                'title'       => 'Important Exam Notification',
                'description' => 'Final exams will be conducted from next month.',
                'category'    => 'Exam',
                'author'      => 'Admin',
                'notice_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'file'        => 'exam_notice.pdf',
                'icon'        => 'fa-solid fa-bell', // Example FontAwesome icon
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Holiday Announcement',
                'description' => 'The school will be closed for the upcoming festival.',
                'category'    => 'Holiday',
                'author'      => 'Principal',
                'notice_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'file'        => 'holiday_announcement.pdf',
                'icon'        => 'fa-solid fa-sun', // Example FontAwesome icon
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'New Library Books Available',
                'description' => 'New books have been added to the library.',
                'category'    => 'Library',
                'author'      => 'Librarian',
                'notice_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'file'        => 'library_books.pdf',
                'icon'        => 'fa-solid fa-book', // Example FontAwesome icon
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ]);
    }
}
