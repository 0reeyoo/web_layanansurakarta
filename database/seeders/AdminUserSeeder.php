<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Super
        $adminEmail = env('ADMIN_EMAIL', 'admin@mail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password123');
        $adminName = env('ADMIN_NAME', 'Administrator');

        $admin = User::where('email', $adminEmail)->first();

        if (! $admin) {
            User::create([
                'name' => $adminName,
                'email' => $adminEmail,
                'role' => 'admin',
                'password' => Hash::make($adminPassword),
            ]);
        } else if ($admin->role !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }

        // Admin Dinas PUPR
        if (!User::where('email', 'admin-pupr@mail.com')->first()) {
            User::create([
                'name' => 'Admin PUPR',
                'email' => 'admin-pupr@mail.com',
                'role' => 'admin',
                'dinas_role' => 'PUPR',
                'password' => Hash::make('password123'),
            ]);
        }

        // Admin Dinas DLH
        if (!User::where('email', 'admin-dlh@mail.com')->first()) {
            User::create([
                'name' => 'Admin DLH',
                'email' => 'admin-dlh@mail.com',
                'role' => 'admin',
                'dinas_role' => 'DLH',
                'password' => Hash::make('password123'),
            ]);
        }

        // Admin Dinas PERHUBUNGAN
        if (!User::where('email', 'admin-perhubungan@mail.com')->first()) {
            User::create([
                'name' => 'Admin Perhubungan',
                'email' => 'admin-perhubungan@mail.com',
                'role' => 'admin',
                'dinas_role' => 'PERHUBUNGAN',
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
