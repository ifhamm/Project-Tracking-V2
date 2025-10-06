<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'nik' => '000005',
                'password' => Hash::make('123'),
                'role' => 'Superadmin',
                'position' => 'Head Office',
            ],
            [
                'name' => 'Admin',
                'nik' => '200156',
                'password' => Hash::make('200156'),
                'role' => 'Admin',
                'position' => 'Office',
            ],
            [
                'name' => 'Mechanic',
                'nik' => '140305',
                'password' => Hash::make('140305'),
                'role' => 'Mechanic',
                'position' => 'Workshop',
            ],
            [
                'name' => 'Quality Inspector',
                'nik' => '160183',
                'password' => Hash::make('160183'),
                'role' => 'Quality Inspector',
                'position' => 'Inspection',
            ],
            [
                'name' => 'Quality CVDR',
                'nik' => '130130',
                'password' => Hash::make('130130'),
                'role' => 'Quality CVDR',
                'position' => 'Document Review',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['nik' => $user['nik']], $user);
        }
    }
}
