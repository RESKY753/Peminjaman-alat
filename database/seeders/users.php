<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'username' => 'Admin',
                'telp' => '089123331313',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'petugas',
                'telp' =>  '088113431233',
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'peminjam',
                'telp' => '087123442322',
                'email' => 'peminjam@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'peminjam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
