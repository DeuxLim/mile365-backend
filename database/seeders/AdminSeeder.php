<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'full_name' => 'Kenneth Marcelino',
                'email' => 'kennethmarcelino@gmail.com',
                'password' => 'Test123123!',
                'status' => 'active',
            ],
            [
                'full_name' => 'Daniel Banawa',
                'email' => 'danielbanawa@gmail.com',
                'password' => 'Test123123!',
                'status' => 'active',
            ],
            [
                'full_name' => 'Conrad Cruz',
                'email' => 'conradcruz@gmail.com',
                'password' => 'Test123123!',
                'status' => 'active',
            ],
        ];

        $role = Role::where('name', 'club_admin')->first();

        if (!$role) {
            throw new \Exception('Role club_admin does not exist. Seed roles first.');
        }

        foreach ($admins as $admin) {
            $user = User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'full_name' => $admin['full_name'],
                    'password' => Hash::make($admin['password']),
                    'status' => $admin['status'],
                ]
            );

            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
