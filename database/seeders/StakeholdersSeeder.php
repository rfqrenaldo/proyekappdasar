<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stakeholder;

class StakeholdersSeeder extends Seeder
{
    public function run()
    {
        $stakeholders = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'nomor_telepon' => '081234567890', 'email' => 'andi.wijaya@example.com', 'foto' => 'https://tse3.mm.bing.net/th?id=OIP.r2cEHrQjwEnR22tovPZ7hgHaLG&pid=Api&P=0&h=220'],
            ['id' => 2, 'nama' => 'Budi Santoso', 'nomor_telepon' => '081345678901', 'email' => 'budi.santoso@example.com', 'foto' => 'https://www.tagar.id/Asset/uploads2019/1571856085559-tito-karnavian.jpg'],
            ['id' => 3, 'nama' => 'Citra Lestari', 'nomor_telepon' => '081456789012', 'email' => 'citra.lestari@example.com', 'foto' => 'https://tse3.mm.bing.net/th?id=OIP.IBLggvUvGXWktexa7dXDngHaJz&pid=Api&P=0&h=220'],
            ['id' => 4, 'nama' => 'Dewi Permata', 'nomor_telepon' => '081567890123', 'email' => 'dewi.permata@example.com', 'foto' => 'https://i0.wp.com/kliktrend.com/wp-content/uploads/2022/08/Veronica-Tan-2.jpg?resize=696%2C522&ssl=1'],
            ['id' => 5, 'nama' => 'Eko Prasetyo', 'nomor_telepon' => '081678901234', 'email' => 'eko.prasetyo@example.com', 'foto' => 'https://www.tagar.id/Asset/uploads2019/1571857927198-bahlil-lahadalia.jpg'],
        ];


        foreach ($stakeholders as $stakeholder) {
            Stakeholder::create($stakeholder);
        }
    }
}
