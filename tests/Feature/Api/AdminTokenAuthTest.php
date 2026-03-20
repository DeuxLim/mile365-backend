<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;

uses(RefreshDatabase::class);

it('logs in an admin and returns a bearer token', function () {
    $user = createAdminUser();

    $response = $this->postJson('/api/admin/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'message' => 'Login successful',
            'token_type' => 'Bearer',
        ])
        ->assertJsonStructure([
            'message',
            'token',
            'token_type',
            'user' => ['id', 'email'],
        ]);

    expect(PersonalAccessToken::count())->toBe(1);
});

it('returns the authenticated admin with a bearer token', function () {
    $user = createAdminUser();
    $token = $user->createToken('admin-api')->plainTextToken;

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/admin/me')
        ->assertOk()
        ->assertJsonPath('user.id', $user->id);
});

it('revokes the current bearer token on logout', function () {
    $user = createAdminUser();
    $token = $user->createToken('admin-api')->plainTextToken;

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/admin/logout')
        ->assertOk()
        ->assertJson([
            'message' => 'Logged out successfully',
        ]);

    expect(PersonalAccessToken::count())->toBe(0);
});

function createAdminUser(): User
{
    $permission = new Permission();
    $permission->forceFill([
        'name' => 'admin_access',
    ])->save();

    $role = new Role();
    $role->forceFill([
        'name' => 'club_admin',
    ])->save();

    $role->permissions()->attach($permission);

    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $user->roles()->attach($role);

    return $user;
}
