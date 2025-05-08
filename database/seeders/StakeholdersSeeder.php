<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stakeholder;

class StakeholdersSeeder extends Seeder
{
    public function run()
    {
        $stakeholders = [
            ['id' => 1, 'nama' => 'PT Maju Jaya', 'kategori' => 'Eksternal', 'nomor_telepon' => '081234567890', 'email' => 'majujaya@example.com', 'foto' => 'https://via.placeholder.com/150'],
            ['id' => 2, 'nama' => 'Bagian Keuangan', 'kategori' => 'Internal', 'nomor_telepon' => '082345678901', 'email' => 'keuangan@internal.com', 'foto' => 'https://via.placeholder.com/150'],
            ['id' => 3, 'nama' => 'CV Sukses Selalu', 'kategori' => 'Eksternal', 'nomor_telepon' => '083456789012', 'email' => 'suksesselalu@example.com', 'foto' => 'https://via.placeholder.com/150'],
            ['id' => 4, 'nama' => 'Divisi IT', 'kategori' => 'Internal', 'nomor_telepon' => '084567890123', 'email' => 'it@internal.com', 'foto' => 'https://via.placeholder.com/150'],
            ['id' => 5, 'nama' => 'PT Aman Sentosa', 'kategori' => 'Eksternal', 'nomor_telepon' => '085678901234', 'email' => 'amansentosa@example.com', 'foto' => 'https://via.placeholder.com/150'],
        ];

        foreach ($stakeholders as $stakeholder) {
            Stakeholder::create($stakeholder);
        }
    }
}
