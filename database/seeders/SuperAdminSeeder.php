<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin
        $user = User::updateOrCreate(
            ['email' => 'limdeux27@gmail.com'],
            [
                'first_name' => 'Deux',
                'last_name' => 'Lim',
                'password' => Hash::make('Test123123!'),
                'status' => 'active',
            ]
        );

        // Assign Role to the created user
        $role = Role::where('name', 'super_admin')->first();
        if (!$role) {
            throw new \Exception('Role super_admin does not exist. Seed roles first.');
        }
        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
