<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage students', 'manage teachers', 'manage courses',
            'manage attendance', 'manage results', 'manage fees',
            'manage notices', 'manage reports', 'manage departments',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::firstOrCreate(['name' => 'teacher'])->givePermissionTo([
            'manage attendance', 'manage results', 'view dashboard',
        ]);
        Role::firstOrCreate(['name' => 'student'])->givePermissionTo([
            'view dashboard',
        ]);
        Role::firstOrCreate(['name' => 'accountant'])->givePermissionTo([
            'manage fees', 'manage reports', 'view dashboard',
        ]);
    }
}