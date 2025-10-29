<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ล้าง cache ของ Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1) สร้าง permissions
        $permissions = [
            'view',
            'create',
            'edit',
            'delete',
            'file import',
            'manage users',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2) สร้าง roles
        $userRole  = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $superRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);

        // 3) สร้าง user admin เริ่มต้น
        $adminUser = User::firstOrCreate(
            ['email' => 'dear0850568134@gmail.com'],
            [
                'name' => 'IS Phongsakron',
                'password' => bcrypt('11111111'),
            ]
        );

        if (! $adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        $adminUser->syncPermissions([
            'view',
            'create',
            'edit',
            'delete',
            'file import',
            'manage users',
        ]);

        // 4) สร้าง user superadmin เริ่มต้น
        $superUser = User::firstOrCreate(
            ['email' => 'SA@gmail.com'],
            [
                'name' => 'SA',
                'password' => bcrypt('11111111'),
            ]
        );

        if (! $superUser->hasRole('superadmin')) {
            $superUser->assignRole($superRole);
        }

        // superadmin มีทุก permission
        $superUser->syncPermissions(Permission::all());

        // 5) ✅ สร้าง user ธรรมดา (มีสิทธิ์แค่ view)
        $normalUser = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Normal User',
                'password' => bcrypt('11111111'),
            ]
        );

        if (! $normalUser->hasRole('user')) {
            $normalUser->assignRole($userRole);
        }

        // ให้สิทธิ์เฉพาะ view
        $normalUser->syncPermissions(['view']);

        // ล้าง cache อีกครั้ง
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
