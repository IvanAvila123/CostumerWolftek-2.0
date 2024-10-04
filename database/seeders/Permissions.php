<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'ver-usuario',
            'ver-permiso',
            'ver-roles',
            'ver-distribuidor',
            'ver-oportunidad',
            'editar-cliente',
            'ver-cambios',
            'eliminar-cliente',
            'ver-cambio',
            'crear-cliente',
            'ver-eliminados',
            'ver-linea',
            'crear-linea',
            'editar-linea',
            'borrar-linea',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear o recuperar el rol de SuperAdmin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Asignar todos los permisos al rol de SuperAdmin
        $superAdminRole->givePermissionTo(Permission::all());

        // Asignar el rol de SuperAdmin al usuario SuperAdmin
        // Asumiendo que ya tienes un usuario SuperAdmin creado
        $superAdmin = User::where('username', 'superadmin')->first();
        if ($superAdmin) {
            $superAdmin->assignRole($superAdminRole);
        }

        $this->command->info('Permisos creados y asignados al SuperAdmin exitosamente.');
    }
}
