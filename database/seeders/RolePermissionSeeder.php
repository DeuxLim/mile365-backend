<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $clubAdmin = Role::create(['name' => 'club_admin']);
        $member = Role::create(['name' => 'member']);

        // Member Management permissions
        $viewMembers = Permission::create(['name' => 'view_members']);
        $approveMembers = Permission::create(['name' => 'approve_members']);
        $manageMembers = Permission::create(['name' => 'manage_members']);

        // Admin Management permissions
        $manageAdmins = Permission::create(['name' => 'manage_admins']);

        // super_admin gets everything
        $superAdmin->permissions()->attach([
            $viewMembers->id,
            $approveMembers->id,
            $manageMembers->id,
            $manageAdmins->id
        ]);

        // club_admin permissions
        $clubAdmin->permissions()->attach([
            $viewMembers->id,
            $approveMembers->id,
            $manageMembers->id,
        ]);

        // member permissions
        $member->permissions()->attach([]);
    }
}
