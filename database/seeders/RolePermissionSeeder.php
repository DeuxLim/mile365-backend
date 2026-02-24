<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create roles
        $superAdmin = Role::updateOrCreate(['name' => 'super_admin']);
        $clubAdmin = Role::updateOrCreate(['name' => 'club_admin']);
        $member = Role::updateOrCreate(['name' => 'member']);

        // Member Management permissions
        $viewMembers = Permission::updateOrCreate(['name' => 'view_members']);
        $approveMembers = Permission::updateOrCreate(['name' => 'approve_members']);
        $manageMembers = Permission::updateOrCreate(['name' => 'manage_members']);

        // Admin Management permissions
        $manageAdmins = Permission::updateOrCreate(['name' => 'manage_admins']);

        // super_admin gets everything
        $superAdmin->permissions()->syncWithoutDetaching([
            $viewMembers->id,
            $approveMembers->id,
            $manageMembers->id,
            $manageAdmins->id
        ]);

        // club_admin permissions
        $clubAdmin->permissions()->syncWithoutDetaching([
            $viewMembers->id,
            $approveMembers->id,
            $manageMembers->id,
        ]);

        // member has no default permissions for now
        // leave empty intentionally
    }
}
