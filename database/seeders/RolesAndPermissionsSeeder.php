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

        // 2) สร้าง roles (ไม่ assign permission ให้ role ใด ๆ)
        $userRole  = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $superRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);

        // 3) สร้าง user เริ่มต้น
        $adminUser = User::firstOrCreate(
            ['email' => 'dear0850568134@gmail.com'],
            [
                'name' => 'IS Phongsakron',
                'password' => bcrypt('11111111'),
            ]
        );

        // assign role (แค่จัดกลุ่ม ไม่ได้กำหนดสิทธิ์อัตโนมัติ)
        if (! $adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // assign permission แบบราย user เท่านั้น
        $adminUser->syncPermissions([
            'view',
            'create',
            'edit',
            'delete',
            'file import',
            'manage users',
        ]);

        // ล้าง cache อีกครั้ง
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
