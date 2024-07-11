<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'name' => 'Usuario Ejemplo 1',
            'email' => 'usuario1@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Ejemplo 2',
            'email' => 'usuario2@example.com',
            'password' => Hash::make('password'),
        ]);

        

        
        \App\Models\User::factory(10)->create();
    }
}
