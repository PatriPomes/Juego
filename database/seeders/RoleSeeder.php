<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1=Role::create(['name'=>'Admin']);
        $role2=Role::create(['name'=> 'Player']);

        Permission::create(['name'=>'admin.home'])->syncRoles([$role1,$role2]); //varios roles a un mismo permiso
        //ammpliar permisos cuando esten todos los metodos, 
        //para actualizar cuando se amplie php artisan migrate:fresh -seed
        //Permission::create(['name'=>'admin.home'])->assingRole($role1); solo un rol por permiso

    }
}