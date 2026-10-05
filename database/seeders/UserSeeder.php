<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ---------- ADMIN ----------
        if (User::where('email', 'admin@example.com')->doesntExist()) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com', // username admin
                'role' => 'admin',
                'password' => 'Admin123!', // password admin
            ]);
            // Assign role if spatie/permission is installed
            if (method_exists($admin, 'assignRole')) {
                $admin->assignRole('admin');
            }
        }

        // ---------- PEGAWAI ----------
        if (User::where('email', 'pegawai@example.com')->doesntExist()) {
            $pegawai = User::create([
                'name' => 'Pegawai',
                'email' => 'pegawai@example.com', // username pegawai
                'role' => 'staff',
                'password' => 'Pegawai123!', // password pegawai
            ]);
            // Assign role if spatie/permission is installed
            if (method_exists($pegawai, 'assignRole')) {
                $pegawai->assignRole('pegawai');
            }
        }
    }
}
