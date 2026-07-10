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
        $admin = User::create([
            'name'     => 'DOT Administrator',
            'email'    => 'admin@eturismo.gov',
            'password' => Hash::make('Admin@123!'),
            'role'     => 'admin',
            'contact'  => '09171234567',
        ]);

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
            Destination::create($data);
        }

        // -------------------------------------------------------
        // 3. Staff Accounts (one per destination)
        // -------------------------------------------------------
        $destModels = Destination::all();
        foreach ($destModels as $i => $dest) {
            User::create([
                'name'                    => 'Staff - ' . $dest->name,
                'email'                   => 'staff' . ($i + 1) . '@eturismo.gov',
                'password'                => Hash::make('Staff@123!'),
                'role'                    => 'staff',
                'contact'                 => '0917000000' . ($i + 1),
                'assigned_destination_id' => $dest->id,
            ]);
        }

        // -------------------------------------------------------
        // 4. Sample Tourist Accounts
        // -------------------------------------------------------
        $tourists = [
            ['name' => 'Maria Santos',  'email' => 'maria@example.com',  'classification' => 'Local'],
            ['name' => 'Juan Dela Cruz', 'email' => 'juan@example.com',   'classification' => 'Domestic'],
            ['name' => 'James Miller',  'email' => 'james@example.com',   'classification' => 'Foreign'],
        ];

        foreach ($tourists as $tourist) {
            User::create([
                'name'           => $tourist['name'],
                'email'          => $tourist['email'],
                'password'       => Hash::make('Tourist@123!'),
                'role'           => 'tourist',
                'contact'        => '09191234567',
                'classification' => $tourist['classification'],
                'id_type'        => 'National ID',
                'id_number'      => 'NID-' . rand(100000, 999999),
            ]);
        }

        $this->command->info('✅ E-Turismo seeded successfully!');
        $this->command->info('   Admin   → admin@eturismo.gov  / Admin@123!');
        $this->command->info('   Staff 1 → staff1@eturismo.gov / Staff@123!');
        $this->command->info('   Tourist → maria@example.com   / Tourist@123!');
    }
}
