<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Permission::create(['name' => 'ges_utilisateurs']);
        // Permission::create(['name' => 'ges_roles']);
        // Permission::create(['name' => 'ges_permissions']);
        // Permission::create(['name' => 'ges_outils']);
        // Permission::create(['name' => 'ges_ventes']);
        // Permission::create(['name' => 'ges_s']);

        // OU 
        // $permissions = [
        //     'ges_utilisateurs',
        //     'ges_roles',
        //     'g_permissions',
        //     'ges_outils',
        //     'ges_ventes',
        //     'ges_categories', 
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }


        // Role::firstOrCreate(['name' => 'adminis']);
        // Role::firstOrCreate(['name' => 'managers']);

        // Vérifie si le rôle admin existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crée l'utilisateur admin s'il n'existe pas déjà
        $admin = User::firstOrCreate(
            ['email' => 'fatim@wstock.com'],
            [
                'first_name' => 'Fatima',
                'last_name' => 'DIEYE',
                'username' => 'fatim',
                'user_ref' => 'fadi00',
                'password' => Hash::make('Admin@123'), // Mot de passe sécurisé
                'is_active' => true,
                'profile_completed' => true,
                'force_password_reset' => true,
                'email_verified_at' => now(),
            ]
        );

        // Assigne le rôle admin
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

                echo "\nAdmin créé !\nEmail : fatim@wstock.com\nPassword : Admin@123\n";

    }
}
