<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Admin Utama',
                'username' => 'admin',
                'no_hp' => '081234567890',
                'password' => Hash::make('password'),
                'status' => 'aktif',
            ]
        );
    }
}