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
        $user = User::create([
            'full_name' => 'Deux Lim',
            'email' => 'limdeux27@gmail.com',
            'password' => Hash::make('Test123123!'),
            'status' => 'active',
        ]);

        // Assign Role to the created user
        $role = Role::where('name', 'super_admin')->first();
        $user->roles()->attach($role->id);
    }
}
