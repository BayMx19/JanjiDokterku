<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'Administrator')->value('id');
        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'name' => 'Administrator',
            'email' => 'administrator@gmail.com',
            'password' => Hash::make('Administrator123'),
            'role_id' => $adminRoleId,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}