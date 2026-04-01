<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['name' => 'Afi Mensah', 'email' => 'admin@biosachet-togo.tg', 'telephone' => '90123456', 'admin_role' => User::ADMIN_ROLE_SUPER_ADMIN],
            ['name' => 'Kodjo Ayivi', 'email' => 'operations@biosachet-togo.tg', 'telephone' => '91112233', 'admin_role' => User::ADMIN_ROLE_OPERATIONS],
            ['name' => 'Mireille Koffi', 'email' => 'finance@biosachet-togo.tg', 'telephone' => '92223344', 'admin_role' => User::ADMIN_ROLE_FINANCE],
        ];

        foreach ($admins as $admin) {
            User::query()->updateOrCreate(
                ['email' => $admin['email']],
                $admin + [
                    'role' => User::ROLE_ADMIN,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
