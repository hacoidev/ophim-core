<?php

namespace Ophim\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Browse actor',
            'Create actor',
            'Update actor',
            'Delete actor',
            'Browse director',
            'Create director',
            'Update director',
            'Delete director',
            'Browse tag',
            'Create tag',
            'Update tag',
            'Delete tag',
            'Browse studio',
            'Create studio',
            'Update studio',
            'Delete studio',
            'Browse catalog',
            'Create catalog',
            'Update catalog',
            'Delete catalog',
            'Browse category',
            'Create category',
            'Update category',
            'Delete category',
            'Browse region',
            'Create region',
            'Update region',
            'Delete region',
            'Browse crawl schedule',
            'Create crawl schedule',
            'Update crawl schedule',
            'Delete crawl schedule',
            'Browse movie',
            'Create movie',
            'Update movie',
            'Delete movie',
            'Browse user',
            'Create user',
            'Update user',
            'Delete user',
            'Browse role',
            'Create role',
            'Update role',
            'Delete role',
            'Browse permission',
            'Create permission',
            'Update permission',
            'Delete permission',
            'Browse episode',
            'Create episode',
            'Update episode',
            'Delete episode',
            'Browse menu',
            'Create menu',
            'Update menu',
            'Delete menu',
            'Delete menu item',
            'Browse plugin',
            'Update plugin',
            'Customize theme',
        ];

        $admin = Role::firstOrCreate(['name' => "Admin", 'guard_name' => 'backpack']);
        foreach ($permissions as $index => $permission) {
            $result = Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'backpack'
            ]);

            $admin->givePermissionTo($permission);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
    }
}
