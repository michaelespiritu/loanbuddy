<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'can add company']);
        Permission::create(['name' => 'can add employee']);
        Permission::create(['name' => 'can add barrower']);
        
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'company owner']);
        $role->givePermissionTo('can add employee');
        $role->givePermissionTo('can add barrower');

        $role = Role::create(['name' => 'employee'])
            ->givePermissionTo(['can add barrower']);

    }
}
