<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Owner
        User::factory()->create([
            'name' => 'Owner User',
            'email' => 'me@shiplujs.com',
            'username' => 'owner',
            'role' => 'owner',
            'password' => Hash::make('password'),
            'status' => true,
        ]);

        // Create Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@shiplujs.com',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'status' => true,

        ]);

        // Create Doctor
        User::factory()->create([
            'name' => 'Doctor User',
            'email' => 'doctor@shiplujs.com',
            'username' => 'doctor',
            'role' => 'doctor',
            'password' => Hash::make('password'),
            'status' => true,

        ]);

        // Create Patient
        User::factory()->create([
            'name' => 'Patient User',
            'email' => 'patient@shiplujs.com',
            'username' => 'patient',
            'role' => 'patient',
            'password' => Hash::make('password'),
            'status' => true,

        ]);

        $this->call([
                InvestigationsSeeder::class,
                ChiefComplaintsSeeder::class,
                MedicineSeeder::class,
            ]);
    }
}
