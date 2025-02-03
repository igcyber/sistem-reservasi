<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '+6285389360934',
            'email' => 'admin@example.com',
            'photo' => null,
            'password' => Hash::make('password'),
            'role_id' => 1, //Administrator
        ]);

        User::factory()->count(3)->create([
            'role_id' => 2,
        ]);

        User::factory()->count(10)->create([
            'role_id' => 3
        ]);
    }
}
