<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin Poliklinik',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Doktor',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
            ],
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('pasien123'),
                'role' => 'pasien',
            ],
        ];
        
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
