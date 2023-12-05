<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roll;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    $this->call(RoleSeeder::class);

       $users= User::factory(5)
        ->has(Roll::factory()->count(5))
        ->create();

        foreach ($users as $user) {
            $user->assignRole('Player');
        }

        User::create([
            'name'=>'Patri',
            'email'=>'patrimanzanas@hotmail.com',
            'password'=>bcrypt('123aBc/*-')
        ])->assignRole('Admin');
                
    }
   
}
