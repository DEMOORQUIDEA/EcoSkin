<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the admin role exists
        $adminRole = Role::where('name', 'admin')->first();
        if (!$adminRole) {
            $adminRole = Role::create(['name' => 'admin']);
        }

        $admins = [
            ['name' => 'Orquidea', 'email' => 'orquidea@ecoskin.com'],
            ['name' => 'Karen', 'email' => 'karen@ecoskin.com'],
            ['name' => 'Obet', 'email' => 'obet@ecoskin.com'],
            ['name' => 'Dayana', 'email' => 'dayana@ecoskin.com'],
            ['name' => 'Alondra', 'email' => 'alondraeco@gmail.com'],
        ];

        foreach ($admins as $adminData) {
            $user = User::updateOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => Hash::make('ECOSKIN2025'),
                    'email_verified_at' => now(),
                ]
            );

            // Assign admin role
            if (!$user->hasRole('admin')) {
                $user->assignRole($adminRole);
            }
        }
    }
}
