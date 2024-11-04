<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Anggota;
use App\Models\Anggota_team;
use App\Models\Category;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Stakeholder;
use App\Models\Team;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     private $anggotaTeam = [
        ['id' => 1, 'member_id' => 1, 'team_id' => 1, 'role' => 'pm'],
        ['id' => 2, 'member_id' => 2, 'team_id' => 1, 'role' => 'fe'],
        ['id' => 3, 'member_id' => 3, 'team_id' => 1, 'role' => 'be'],
        ['id' => 4, 'member_id' => 4, 'team_id' => 1, 'role' => 'ui_ux'],

        ['id' => 5, 'member_id' => 5, 'team_id' => 2, 'role' => 'pm'],
        ['id' => 6, 'member_id' => 6, 'team_id' => 2, 'role' => 'fe'],
        ['id' => 7, 'member_id' => 7, 'team_id' => 2, 'role' => 'be'],
        ['id' => 8, 'member_id' => 8, 'team_id' => 2, 'role' => 'ui_ux'],

        ['id' => 9, 'member_id' => 9, 'team_id' => 3, 'role' => 'pm'],
        ['id' => 10, 'member_id' => 10, 'team_id' => 3, 'role' => 'fe'],
        ['id' => 11, 'member_id' => 11, 'team_id' => 3, 'role' => 'be'],
        ['id' => 12, 'member_id' => 12, 'team_id' => 3, 'role' => 'ui_ux'],

        ['id' => 13, 'member_id' => 13, 'team_id' => 4, 'role' => 'pm'],
        ['id' => 14, 'member_id' => 14, 'team_id' => 4, 'role' => 'fe'],
        ['id' => 15, 'member_id' => 15, 'team_id' => 4, 'role' => 'be'],
        ['id' => 16, 'member_id' => 16, 'team_id' => 4, 'role' => 'ui_ux'],

        ['id' => 17, 'member_id' => 17, 'team_id' => 5, 'role' => 'pm'],
        ['id' => 18, 'member_id' => 18, 'team_id' => 5, 'role' => 'fe'],
        ['id' => 19, 'member_id' => 19, 'team_id' => 5, 'role' => 'be'],
        ['id' => 20, 'member_id' => 20, 'team_id' => 5, 'role' => 'ui_ux'],
    ];

    private $anggota = [
        ['id' => 1, 'nama_lengkap' => 'Ahmad Fauzi', 'NIM' => '10/123456/SV/10001', 'foto' => ''],
        ['id' => 2, 'nama_lengkap' => 'Budi Santoso', 'NIM' => '11/123457/SV/10002', 'foto' => ''],
        ['id' => 3, 'nama_lengkap' => 'Citra Permata', 'NIM' => '12/123458/SV/10003', 'foto' => ''],
        ['id' => 4, 'nama_lengkap' => 'Dewi Lestari', 'NIM' => '13/123459/SV/10004', 'foto' => ''],
        ['id' => 5, 'nama_lengkap' => 'Eko Prasetyo', 'NIM' => '14/123460/SV/10005', 'foto' => ''],
        ['id' => 6, 'nama_lengkap' => 'Fajar Saputra', 'NIM' => '15/123461/SV/10006', 'foto' => ''],
        ['id' => 7, 'nama_lengkap' => 'Gita Ananda', 'NIM' => '16/123462/SV/10007', 'foto' => ''],
        ['id' => 8, 'nama_lengkap' => 'Hari Purnomo', 'NIM' => '17/123463/SV/10008', 'foto' => ''],
        ['id' => 9, 'nama_lengkap' => 'Indra Wijaya', 'NIM' => '18/123464/SV/10009', 'foto' => ''],
        ['id' => 10, 'nama_lengkap' => 'Joko Susilo', 'NIM' => '19/123465/SV/10010', 'foto' => ''],
        ['id' => 11, 'nama_lengkap' => 'Kiki Amalia', 'NIM' => '20/123466/SV/10011', 'foto' => ''],
        ['id' => 12, 'nama_lengkap' => 'Lala Putri', 'NIM' => '21/123467/SV/10012', 'foto' => ''],
        ['id' => 13, 'nama_lengkap' => 'Mahmud Rahman', 'NIM' => '22/123468/SV/10013', 'foto' => ''],
        ['id' => 14, 'nama_lengkap' => 'Nina Safira', 'NIM' => '23/123469/SV/10014', 'foto' => ''],
        ['id' => 15, 'nama_lengkap' => 'Oki Firmansyah', 'NIM' => '24/123470/SV/10015', 'foto' => ''],
        ['id' => 16, 'nama_lengkap' => 'Putri Ayu', 'NIM' => '25/123471/SV/10016', 'foto' => ''],
        ['id' => 17, 'nama_lengkap' => 'Qori Rizky', 'NIM' => '26/123472/SV/10017', 'foto' => ''],
        ['id' => 18, 'nama_lengkap' => 'Rian Pradipta', 'NIM' => '27/123473/SV/10018', 'foto' => ''],
        ['id' => 19, 'nama_lengkap' => 'Siti Nuraini', 'NIM' => '28/123474/SV/10019', 'foto' => ''],
        ['id' => 20, 'nama_lengkap' => 'Taufik Hidayat', 'NIM' => '29/123475/SV/10020', 'foto' => ''],
    ];

    private $team = [
        ['id' => 1, 'nama_tim' => 'Tim Alpha'],
        ['id' => 2, 'nama_tim' => 'Tim Bravo'],
        ['id' => 3, 'nama_tim' => 'Tim Charlie'],
        ['id' => 4, 'nama_tim' => 'Tim Delta'],
        ['id' => 5, 'nama_tim' => 'Tim Echo'],
    ];

    private $stakeholders = [
        ['id' => 1, 'nama' => 'Andi Wijaya', 'nomor_telepon' => '081234567890', 'email' => 'andi.wijaya@example.com', 'foto' => ''],
        ['id' => 2, 'nama' => 'Budi Santoso', 'nomor_telepon' => '081345678901', 'email' => 'budi.santoso@example.com', 'foto' => ''],
        ['id' => 3, 'nama' => 'Citra Lestari', 'nomor_telepon' => '081456789012', 'email' => 'citra.lestari@example.com', 'foto' => ''],
        ['id' => 4, 'nama' => 'Dewi Permata', 'nomor_telepon' => '081567890123', 'email' => 'dewi.permata@example.com', 'foto' => ''],
        ['id' => 5, 'nama' => 'Eko Prasetyo', 'nomor_telepon' => '081678901234', 'email' => 'eko.prasetyo@example.com', 'foto' => ''],
    ];

    private $proyek = [
        ['id' => 1, 'nama_proyek' => 'Sistem Informasi Akademik', 'stakeholder_id' => 1, 'logo' => 'logo1.png', 'deskripsi' => 'Proyek pengembangan sistem akademik', 'team_id' => 1],
        ['id' => 2, 'nama_proyek' => 'Aplikasi Peminjaman Buku', 'stakeholder_id' => 2, 'logo' => 'logo2.png', 'deskripsi' => 'Proyek aplikasi perpustakaan', 'team_id' => 2],
        ['id' => 3, 'nama_proyek' => 'Website E-commerce', 'stakeholder_id' => 3, 'logo' => 'logo3.png', 'deskripsi' => 'Proyek pengembangan e-commerce', 'team_id' => 3],
        ['id' => 4, 'nama_proyek' => 'Aplikasi Reservasi', 'stakeholder_id' => 4, 'logo' => 'logo4.png', 'deskripsi' => 'Aplikasi reservasi untuk restoran', 'team_id' => 4],
        ['id' => 5, 'nama_proyek' => 'Sistem Keuangan Sekolah', 'stakeholder_id' => 5, 'logo' => 'logo5.png', 'deskripsi' => 'Sistem keuangan untuk sekolah', 'team_id' => 5],
    ];

    private $kategori = [
        ['id' => 1, 'nama_kategori' => 'PAD1'],
        ['id' => 2, 'nama_kategori' => 'PAD2'],
    ];


    private $kategori_proyek = [
        ['id' => 1, 'project_id' => 1, 'category_id' => 1],
        ['id' => 2, 'project_id' => 2, 'category_id' => 1],
        ['id' => 3, 'project_id' => 3, 'category_id' => 2],
        ['id' => 4, 'project_id' => 4, 'category_id' => 2],
        ['id' => 5, 'project_id' => 5, 'category_id' => 1],
    ];
    private $tahun_proyek = [
        ['id' => 1, 'project_id' => 1, 'tahun' => 2021],
        ['id' => 2, 'project_id' => 2, 'tahun' => 2022],
        ['id' => 3, 'project_id' => 3, 'tahun' => 2023],
        ['id' => 4, 'project_id' => 4, 'tahun' => 2021],
        ['id' => 5, 'project_id' => 5, 'tahun' => 2023],
    ];

    private $users = [
        [
            'name' => 'Muhammad Fakhrurrifqi',
            'email' => 'rifqi_ilkom@mail.ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Irkham Huda',
            'email' => 'irkham@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Imam Fahrurrozi',
            'email' => 'imam.fahrurrozi@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Firma Syahrian',
            'email' => 'fsyahrian@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Divi Galih Prasetyo Putri',
            'email' => 'divi.galih@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Yusron Fuadi',
            'email' => 'yusron.fuadi@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Anindita Suryarasmi',
            'email' => 'anindita@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Umar Taufiq',
            'email' => 'umartaufiq8284@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Airlangga Adi Hermawan',
            'email' => 'airlangga.adi.hermawan@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Dinar Nugroho Pratomo',
            'email' => 'dinar.nugroho.p@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Ganjar Alfian',
            'email' => 'ganjar.alfian@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Rochana Prih Hastuti',
            'email' => 'rochana.prih.h@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Margareta Hardiyanti',
            'email' => 'margareta.hardiyanti@ugm.ac.id',
            'password' => 'password123',
            'role' => 'dosen',
            'google_id' => null,
        ],
        [
            'name' => 'Syafiq Abdillah',
            'email' => 'syafiq.abdillah@ugm.ac.id',
            'password' => 'adminpassword',
            'role' => 'admin',
            'google_id' => null,
        ],
    ];


    public function run(): void
    {
        foreach ($this->anggotaTeam as $key => $value) {
            Anggota_team::create($value);
        }
        foreach($this->anggota as $key=> $value){
            Anggota::create($value);
        }
        foreach($this->team as $key=> $value){
            Team::create($value);
        }
        foreach($this->stakeholders as $key=> $value){
            Stakeholder::create($value);
        }
        foreach($this->proyek as $key=> $value){
            Project::create($value);
        }
        foreach($this->kategori as $key=> $value){
            Category::create($value);
        }
        foreach($this->kategori_proyek as $key=> $value){
            ProjectCategory::create($value);
        }
        foreach($this->tahun_proyek as $key=> $value){
            Year::create($value);
        }
        foreach($this->users as $key=> $value){
            $value["password"] = Hash::make($value["password"]);
            User::create($value);
        }


    }
}
