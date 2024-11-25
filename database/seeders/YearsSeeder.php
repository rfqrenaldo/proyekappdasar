<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Year;

class YearsSeeder extends Seeder
{
    public function run()
    {
        $years = [
        ['id' => 1, 'project_id' => 1, 'tahun' => 2021],
        ['id' => 2, 'project_id' => 2, 'tahun' => 2022],
        ['id' => 3, 'project_id' => 3, 'tahun' => 2023],
        ['id' => 4, 'project_id' => 4, 'tahun' => 2021],
        ['id' => 5, 'project_id' => 5, 'tahun' => 2023],
    ];

        foreach ($years as $year) {
            Year::create($year);
        }
    }
}
