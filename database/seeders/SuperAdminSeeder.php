<?php

namespace Database\Seeders;

use App\Models\Distribuidor;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Asignar todos los permisos existentes al rol de Super Admin
        $permissions = Permission::all();
        $superAdminRole->syncPermissions($permissions);

        // Crear usuario Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('admin12345678'), // Cambia esto por una contraseña segura
                'email_verified_at' => now(),
                'distribuidor_id' => '1',
                'is_active' => true,
            ]
        );

        // Asignar rol de Super Admin al usuario
        $superAdmin->assignRole($superAdminRole);

        // Crear un distribuidor asociado al Super Admin
        $distribuidor = Distribuidor::firstOrCreate(
            ['correo' => 'wolftek@gmail.com'],
            [
                'nombre' => 'WOLFTEK SA DE CV',
                'apellido' => '',
                'telefono' => '5555555555',
                'user_id' => $superAdmin->id,
            ]
        );
    }
}
