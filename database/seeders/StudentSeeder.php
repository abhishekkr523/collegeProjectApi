<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\Student;
// use Illuminate\Support\Str;

// class StudentSeeder extends Seeder
// {
//     public function run()
//     {
       
//         Student::create([
//             'id' => Str::uuid(),
//             'name' => 'John Doe',
//             'roll_no' => '12345',
//             'phone' => '555-1234',
//             'branch' => 'Computer Science',
//             'session' => '2021-2025',
//         ]);

//         Student::create([
//             'id' => Str::uuid(),
//             'name' => 'Jane Smith',
//             'roll_no' => '12346',
//             'phone' => '555-5678',
//             'branch' => 'Electrical Engineering',
//             'session' => '2022-2026',
//         ]);

//         Student::create([
//             'id' =>  Str::uuid(),
//             'name' => 'Alice Johnson',
//             'roll_no' => '12347',
//             'phone' => '555-9101',
//             'branch' => 'Mechanical Engineering',
//             'session' => '2023-2027',
//         ]);
//     }
// }

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $branches = ['Computer Science', 'Mechanical', 'Electrical', 'Civil', 'Electronics', 'IT'];
        $sessions = ['2019-2023', '2020-2024', '2021-2025', '2022-2026'];

        for ($i = 1; $i <= 100; $i++) {
            Student::create([
                'id' => Str::uuid(),
                'name' => $faker->name,
                'roll_no' => 'CS' . str_pad($i, 3, '0', STR_PAD_LEFT), // Example: CS001, CS002...
                'phone' => $faker->unique()->numerify('98########'),
                'email'=> $faker->unique()->email,
                'branch' => $faker->randomElement($branches),
                'session' => $faker->randomElement($sessions),
            ]);
        }
    }
}

