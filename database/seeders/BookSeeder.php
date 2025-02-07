<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Book;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statuses = ['available', 'borrowed', 'reserved'];

        for ($i = 1; $i <= 100; $i++) {
            Book::create([
                'id' => Str::uuid(),
                'title' => $faker->sentence(3), // Generates a book title
                'author' => $faker->name, // Generates an author name
                'publisher' => $faker->company, // Generates a publisher name
                'publication_year' => $faker->numberBetween(1990, 2024), // Random year
                'isbn' => $faker->unique()->isbn13, // Unique ISBN number
                'number_of_pages' => $faker->numberBetween(100, 1000), // Random page count
                'status' => $faker->randomElement($statuses), // Random book status
            ]);
        }
    }
}
