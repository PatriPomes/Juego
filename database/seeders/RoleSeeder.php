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

        
        //ammpliar permisos cuando esten todos los metodos, 
        //para actualizar cuando se amplie php artisan migrate:fresh -seed
        //Permission::create(['name'=>'admin.home'])->assingRole($role1); solo un rol por permiso
        Permission::create(['name'=>'register'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'login'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'logout'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rollDice'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'destroyAllRollDice'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'succesPlayers'])->assignRole($role1);
        Permission::create(['name'=>'rollsPlayer'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'ranking'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'losser'])->assignRole($role1);
        Permission::create(['name'=>'winner'])->assignRole($role1);

    }
}