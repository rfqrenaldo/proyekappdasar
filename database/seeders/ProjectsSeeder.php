<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            ['id' => 1, 'nama_proyek' => 'Sistem Informasi Akademik', 'stakeholder_id' => 1, 'logo' => 'https://tse2.mm.bing.net/th?id=OIP.0dRZ6hjdWHrmN-30OHJ2mAHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek pengembangan sistem akademik', 'team_id' => 1],
                ['id' => 2, 'nama_proyek' => 'Aplikasi Peminjaman Buku', 'stakeholder_id' => 2, 'logo' => 'https://tse1.mm.bing.net/th?id=OIP.VDfRD7B6UORZeinJqmQdeQHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek aplikasi perpustakaan', 'team_id' => 2],
                ['id' => 3, 'nama_proyek' => 'Website E-commerce', 'stakeholder_id' => 3, 'logo' => 'https://tse2.mm.bing.net/th?id=OIP.yKOc__wAqqzS5EYi6Psz4gHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek pengembangan e-commerce', 'team_id' => 3],
                ['id' => 4, 'nama_proyek' => 'Aplikasi Reservasi', 'stakeholder_id' => 4, 'logo' => 'https://png.pngtree.com/png-clipart/20200709/original/pngtree-restaurant-logo-png-image_4009924.jpg', 'deskripsi' => 'Aplikasi reservasi untuk restoran', 'team_id' => 4],
                ['id' => 5, 'nama_proyek' => 'Sistem Keuangan Sekolah', 'stakeholder_id' => 5, 'logo' => 'https://tse3.mm.bing.net/th?id=OIP.6lqGVHIvAR_nMfvX9Thq3QHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Sistem keuangan untuk sekolah', 'team_id' => 5],
            ];
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
