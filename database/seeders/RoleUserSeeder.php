<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get specific users
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        $testUser = User::where('email', 'test@gmail.com')->first();

        // Get specific roles
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Assign Admin role to Admin user
        if ($adminUser && $adminRole) {
            DB::table('role_user')->insert([
                'user_id' => $adminUser->id,
                'role_id' => $adminRole->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assign User role to Test user
        if ($testUser && $userRole) {
            DB::table('role_user')->insert([
                'user_id' => $testUser->id,
                'role_id' => $userRole->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
