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
        Permission::firstOrCreate(['name' => 'g_utilisateurs']);
        Permission::firstOrCreate(['name' => 'g_roles']);
        Permission::firstOrCreate(['name' => 'g_permissions']);
        Permission::firstOrCreate(['name' => 'g_outils']);
        Permission::firstOrCreate(['name' => 'g_ventes']);
        Permission::firstOrCreate(['name' => 'g_factures']);

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['g_utilisateurs', 'g_roles', 'g_permissions', 'g_outils','g_ventes','g_factures']);

        $manager = Role::findByName('manager');
        $manager->givePermissionTo(['g_outils','g_ventes','g_factures']);
       
    }
}

