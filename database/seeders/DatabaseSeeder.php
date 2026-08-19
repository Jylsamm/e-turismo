<?php

namespace Database\Seeders;

use App\Models\Destination;
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
        // -------------------------------------------------------
        // 1. Admin Account
        // -------------------------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@eturismo.com'],
            [
                'name'      => 'TOURISM',
                'last_name' => 'PERSONNEL',
                'password'  => Hash::make('omsi2026'),
                'role'      => 'admin',
                'contact'   => '09171234567',
                'id_verification_status' => 'verified',
            ]
        );

        // -------------------------------------------------------
        // 2. Sample Destinations
        // -------------------------------------------------------
        $destinations = [
            [
                'name'                => 'Bataan Nature Park',
                'initials'            => 'BNP',
                'location'            => 'Balanga City, Bataan',
                'capacity'            => 100,
                'description'         => 'A lush eco-park offering nature trails, bird watching, and fresh mountain air.',
                'availability_status' => 'Available',
            ],
            [
                'name'                => 'Las Casas Filipinas de Acuzar',
                'initials'            => 'LCF',
                'location'            => 'Bagac, Bataan',
                'capacity'            => 80,
                'description'         => 'A heritage resort featuring restored Spanish-era colonial houses from across the Philippines.',
                'availability_status' => 'Available',
            ],
            [
                'name'                => 'Mt. Samat National Shrine',
                'initials'            => 'MSS',
                'location'            => 'Pilar, Bataan',
                'capacity'            => 200,
                'description'         => 'A historic landmark commemorating the heroes of the Bataan Death March, with a panoramic cross.',
                'availability_status' => 'Available',
            ],
            [
                'name'                => 'Pawikan Conservation Center',
                'initials'            => 'PCC',
                'location'            => 'Morong, Bataan',
                'capacity'            => 60,
                'description'         => 'A sea turtle conservation site where you can witness hatchling releases on the beach.',
                'availability_status' => 'Available',
            ],
        ];

        foreach ($destinations as $data) {
            Destination::firstOrCreate(['name' => $data['name']], $data);
        }

        // -------------------------------------------------------
        // 3. Staff Accounts
        // -------------------------------------------------------
        $firstDest = Destination::first();
        User::firstOrCreate(
            ['email' => 'staff@eturismo.com'],
            [
                'name'                    => 'LM Staff',
                'password'                => Hash::make('password'),
                'role'                    => 'staff',
                'contact'                 => '1234567890',
                'assigned_destination_id' => $firstDest ? $firstDest->id : null,
                'id_verification_status'  => 'verified',
            ]
        );

        // -------------------------------------------------------
        // 4. Sample Tourist Accounts
        // -------------------------------------------------------
        User::firstOrCreate(
            ['email' => 'jylsam123@gmail.com'],
            [
                'name'                   => 'JYLSAM',
                'last_name'              => 'QUIROG',
                'password'               => Hash::make('password'),
                'role'                   => 'tourist',
                'contact'                => '09723462733',
                'classification'         => 'Local',
                'id_type'                => 'School ID',
                'id_number'              => '2022-041633',
                'id_verification_status' => 'verified',
            ]
        );

        $this->command->info('✅ E-Turismo seeded successfully!');
        $this->command->info('   Admin   → admin@eturismo.com   / omsi2026');
        $this->command->info('   Staff   → staff@eturismo.com   / password');
        $this->command->info('   Tourist → jylsam123@gmail.com  / password');
    }
}
