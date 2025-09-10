<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Add this line

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Referencer',
            'email' => 'referencer@example.com',
            'password' => Hash::make('password'),
            'role' => 'referencer',
        ]);

        User::create([
            'name' => 'Advisor',
            'email' => 'advisor@example.com',
            'password' => Hash::make('password'),
            'role' => 'advisor',
        ]);
    }
}