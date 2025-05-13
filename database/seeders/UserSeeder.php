<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('welcome'), // default password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => Hash::make('welcome'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
