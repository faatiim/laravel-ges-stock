<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'ges_utilisateurs']);
        Permission::create(['name' => 'ges_roles']);
        Permission::create(['name' => 'ges_permissions']);
        Permission::create(['name' => 'ges_outils']);
        Permission::create(['name' => 'ges_ventes']);
        Permission::create(['name' => 'ges_permissions']);
        Permission::create(['name' => 'ges_s']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['ges_utilisateurs', 'ges_roles', 'ges_permissions', 'ges_outils']);

        $manager = Role::findByName('manager');
        $manager->givePermissionTo(['ges_outils']);
       
    }
}

