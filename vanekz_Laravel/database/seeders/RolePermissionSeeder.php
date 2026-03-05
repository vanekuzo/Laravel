<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);

       
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['edit articles', 'delete articles']);

        $userRole = Role::create(['name' => 'writer']);
        $userRole->givePermissionTo('edit articles');
    }
}