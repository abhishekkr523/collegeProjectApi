<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedRoles();
        // $this->seedBooks();

        // Call all seeders here
        $this->call([
            SemesterSeeder::class,
            StudentSeeder::class,
            SubjectSeeder::class,
            CourseSeeder::class,
            NoticeSeeder::class,
            BookSeeder::class,
            courseCategorySeeder::class
        ]);
    }
    

    /**
     * Seed the roles in the database.
     */
    public function seedRoles()
    {
        \App\Models\Role::create(['name' => 'Admin']);
        \App\Models\Role::create(['name' => 'Teacher']);
        \App\Models\Role::create(['name' => 'HOD']);
        \App\Models\Role::create(['name' => 'Librarian']);
        \App\Models\Role::create(['name' => 'User']);
        $this->call(YearAndSemesterSeeder::class);

    }

    /**
     * Seed the books in the database.
     */
    // public function seedBooks()
    // {
    //     DB::table('books')->insert([
    //         [
    //             'id' => Str::uuid(),
    //             'title' => 'To Kill a Mockingbird',
    //             'author' => 'Harper Lee',
    //             'publisher' => 'J.B. Lippincott & Co.',
    //             'publication_year' => 1960,
    //             'isbn' => '978-0061120084',
    //             'number_of_pages' => 281,
    //             'status' => 'available',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'id' => Str::uuid(),
    //             'title' => '1984',
    //             'author' => 'George Orwell',
    //             'publisher' => 'Secker & Warburg',
    //             'publication_year' => 1949,
    //             'isbn' => '978-0451524935',
    //             'number_of_pages' => 328,
    //             'status' => 'borrowed',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'id' => Str::uuid(),
    //             'title' => 'Pride and Prejudice',
    //             'author' => 'Jane Austen',
    //             'publisher' => 'T. Egerton',
    //             'publication_year' => 1813,
    //             'isbn' => '978-1503290563',
    //             'number_of_pages' => 279,
    //             'status' => 'available',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'id' => Str::uuid(),
    //             'title' => 'The Great Gatsby',
    //             'author' => 'F. Scott Fitzgerald',
    //             'publisher' => 'Charles Scribner\'s Sons',
    //             'publication_year' => 1925,
    //             'isbn' => '978-0743273565',
    //             'number_of_pages' => 180,
    //             'status' => 'reserved',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'id' => Str::uuid(),
    //             'title' => 'Moby-Dick',
    //             'author' => 'Herman Melville',
    //             'publisher' => 'Richard Bentley',
    //             'publication_year' => 1851,
    //             'isbn' => '978-1503280786',
    //             'number_of_pages' => 585,
    //             'status' => 'available',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //     ]);
    // }
}
