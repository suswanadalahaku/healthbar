<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id_role' => 1, // Sesuaikan dengan ID role yang ada
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12341234'), // Enkripsi password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 2,
                'name' => 'Dr. Sanjaya',
                'email' => 'sanjaya@gmail.com',
                'password' => Hash::make('12341234'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
