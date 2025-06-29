<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'id' => 1,
                'nama_proyek' => 'Sistem Informasi Akademik',
                'stakeholder_id' => 1,
                'team_id' => 1,
                'deskripsi' => 'Aplikasi untuk manajemen data akademik mahasiswa dan dosen.',
                'link_proyek' => 'https://example.com/sia',
            ],
            [
                'id' => 2,
                'nama_proyek' => 'E-Commerce Fashion',
                'stakeholder_id' => 2,
                'team_id' => 2,
                'deskripsi' => 'Platform jual beli produk fashion secara online.',
                'link_proyek' => 'https://example.com/ecommerce-fashion',
            ],
            [
                'id' => 3,
                'nama_proyek' => 'Aplikasi Kesehatan Online',
                'stakeholder_id' => 3,
                'team_id' => 3,
                'deskripsi' => 'Layanan konsultasi dan pembelian obat online.',
                'link_proyek' => 'https://example.com/health-app',
            ],
            [
                'id' => 4,
                'nama_proyek' => 'Website Portofolio',
                'stakeholder_id' => 4,
                'team_id' => 4,
                'deskripsi' => 'Website untuk menampilkan hasil karya dan pengalaman profesional.',
                'link_proyek' => 'https://example.com/portfolio',
            ],
            [
                'id' => 5,
                'nama_proyek' => 'Smart Home Automation',
                'stakeholder_id' => 5,
                'team_id' => 5,
                'deskripsi' => 'Sistem kendali rumah pintar berbasis IoT.',
                'link_proyek' => 'https://example.com/smart-home',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
