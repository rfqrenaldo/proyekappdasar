<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Stakeholder;
use App\Models\Team;
use App\Models\Team_member;
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
        ['id' => 1, 'nama_lengkap' => 'Ahmad Fauzi', 'NIM' => '10/123456/SV/10001', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202013-ae798b876c684b976a4ca567b6fe9a71-dff3d4794dc9c7589e41a377ad5dda79.jpg'],
        ['id' => 2, 'nama_lengkap' => 'Budi Santoso', 'NIM' => '11/123457/SV/10002', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202056-ae798b876c684b976a4ca567b6fe9a71-138d35f6586cab0d26157cb22ab42f55.jpg'],
        ['id' => 3, 'nama_lengkap' => 'Citra Permata', 'NIM' => '12/123458/SV/10003', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/10716409841606815885.jpg'],
        ['id' => 4, 'nama_lengkap' => 'Dewi Lestari', 'NIM' => '13/123459/SV/10004', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/18711461251606816166.jpg'],
        ['id' => 5, 'nama_lengkap' => 'Eko Prasetyo', 'NIM' => '14/123460/SV/10005', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202114-ae798b876c684b976a4ca567b6fe9a71-a26a7ee7688b1a4e15a7bc2d300297b0.jpg'],
        ['id' => 6, 'nama_lengkap' => 'Fajar Saputra', 'NIM' => '15/123461/SV/10006', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202131-ae798b876c684b976a4ca567b6fe9a71-86443c7db802fba02d4065d872e3f877.jpg'],
        ['id' => 7, 'nama_lengkap' => 'Gita Ananda', 'NIM' => '16/123462/SV/10007', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/6735678471606816369.jpg'],
        ['id' => 8, 'nama_lengkap' => 'Hari Purnomo', 'NIM' => '17/123463/SV/10008', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/15063774171606816659.jpg'],
        ['id' => 9, 'nama_lengkap' => 'Indra Wijaya', 'NIM' => '18/123464/SV/10009', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202152-ae798b876c684b976a4ca567b6fe9a71-0abe0b0377259c13365966bb30f3f293.jpg'],
        ['id' => 10, 'nama_lengkap' => 'Joko Susilo', 'NIM' => '19/123465/SV/10010', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202013-ae798b876c684b976a4ca567b6fe9a71-dff3d4794dc9c7589e41a377ad5dda79.jpg'],
        ['id' => 11, 'nama_lengkap' => 'Kiki Amalia', 'NIM' => '20/123466/SV/10011', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/18262036551606816845.jpg'],
        ['id' => 12, 'nama_lengkap' => 'Lala Putri', 'NIM' => '21/123467/SV/10012', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/7558260601606816917.jpg'],
        ['id' => 13, 'nama_lengkap' => 'Mahmud Rahman', 'NIM' => '22/123468/SV/10013', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202056-ae798b876c684b976a4ca567b6fe9a71-138d35f6586cab0d26157cb22ab42f55.jpg'],
        ['id' => 14, 'nama_lengkap' => 'Nina Safira', 'NIM' => '23/123469/SV/10014', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/10716409841606815885.jpg'],
        ['id' => 15, 'nama_lengkap' => 'Oki Firmansyah', 'NIM' => '24/123470/SV/10015', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202131-ae798b876c684b976a4ca567b6fe9a71-86443c7db802fba02d4065d872e3f877.jpg'],
        ['id' => 16, 'nama_lengkap' => 'Putri Ayu', 'NIM' => '25/123471/SV/10016', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/18711461251606816166.jpg'],
        ['id' => 17, 'nama_lengkap' => 'Qori Rizky', 'NIM' => '26/123472/SV/10017', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/6735678471606816369.jpg'],
        ['id' => 18, 'nama_lengkap' => 'Rian Pradipta', 'NIM' => '27/123473/SV/10018', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202114-ae798b876c684b976a4ca567b6fe9a71-a26a7ee7688b1a4e15a7bc2d300297b0.jpg'],
        ['id' => 19, 'nama_lengkap' => 'Siti Nuraini', 'NIM' => '28/123474/SV/10019', 'foto' => 'https://api.duniagames.co.id/api/content/upload/file/15063774171606816659.jpg'],
        ['id' => 20, 'nama_lengkap' => 'Taufik Hidayat', 'NIM' => '29/123475/SV/10020', 'foto' => 'https://cdn.idntimes.com/content-images/community/2023/11/img-20231130-202152-ae798b876c684b976a4ca567b6fe9a71-0abe0b0377259c13365966bb30f3f293.jpg'],
    ];


    private $team = [
        ['id' => 1, 'nama_tim' => 'Tim Alpha'],
        ['id' => 2, 'nama_tim' => 'Tim Bravo'],
        ['id' => 3, 'nama_tim' => 'Tim Charlie'],
        ['id' => 4, 'nama_tim' => 'Tim Delta'],
        ['id' => 5, 'nama_tim' => 'Tim Echo'],
    ];

    private $stakeholders = [
        ['id' => 1, 'nama' => 'Andi Wijaya', 'nomor_telepon' => '081234567890', 'email' => 'andi.wijaya@example.com', 'foto' => 'https://tse3.mm.bing.net/th?id=OIP.r2cEHrQjwEnR22tovPZ7hgHaLG&pid=Api&P=0&h=220'],
        ['id' => 2, 'nama' => 'Budi Santoso', 'nomor_telepon' => '081345678901', 'email' => 'budi.santoso@example.com', 'foto' => 'https://www.tagar.id/Asset/uploads2019/1571856085559-tito-karnavian.jpg'],
        ['id' => 3, 'nama' => 'Citra Lestari', 'nomor_telepon' => '081456789012', 'email' => 'citra.lestari@example.com', 'foto' => 'https://tse3.mm.bing.net/th?id=OIP.IBLggvUvGXWktexa7dXDngHaJz&pid=Api&P=0&h=220'],
        ['id' => 4, 'nama' => 'Dewi Permata', 'nomor_telepon' => '081567890123', 'email' => 'dewi.permata@example.com', 'foto' => 'https://i0.wp.com/kliktrend.com/wp-content/uploads/2022/08/Veronica-Tan-2.jpg?resize=696%2C522&ssl=1'],
        ['id' => 5, 'nama' => 'Eko Prasetyo', 'nomor_telepon' => '081678901234', 'email' => 'eko.prasetyo@example.com', 'foto' => 'https://www.tagar.id/Asset/uploads2019/1571857927198-bahlil-lahadalia.jpg'],
    ];

    private $proyek = [
        ['id' => 1, 'nama_proyek' => 'Sistem Informasi Akademik', 'stakeholder_id' => 1, 'logo' => 'https://tse2.mm.bing.net/th?id=OIP.0dRZ6hjdWHrmN-30OHJ2mAHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek pengembangan sistem akademik', 'team_id' => 1],
        ['id' => 2, 'nama_proyek' => 'Aplikasi Peminjaman Buku', 'stakeholder_id' => 2, 'logo' => 'https://tse1.mm.bing.net/th?id=OIP.VDfRD7B6UORZeinJqmQdeQHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek aplikasi perpustakaan', 'team_id' => 2],
        ['id' => 3, 'nama_proyek' => 'Website E-commerce', 'stakeholder_id' => 3, 'logo' => 'https://tse2.mm.bing.net/th?id=OIP.yKOc__wAqqzS5EYi6Psz4gHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Proyek pengembangan e-commerce', 'team_id' => 3],
        ['id' => 4, 'nama_proyek' => 'Aplikasi Reservasi', 'stakeholder_id' => 4, 'logo' => 'https://png.pngtree.com/png-clipart/20200709/original/pngtree-restaurant-logo-png-image_4009924.jpg', 'deskripsi' => 'Aplikasi reservasi untuk restoran', 'team_id' => 4],
        ['id' => 5, 'nama_proyek' => 'Sistem Keuangan Sekolah', 'stakeholder_id' => 5, 'logo' => 'https://tse3.mm.bing.net/th?id=OIP.6lqGVHIvAR_nMfvX9Thq3QHaHa&pid=Api&P=0&h=220', 'deskripsi' => 'Sistem keuangan untuk sekolah', 'team_id' => 5],
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
    private $images = [
        // Project 1
        ['project_id' => 1, 'link_gambar' => 'https://fastly.picsum.photos/id/593/420/220.jpg?hmac=5cJ_-ytAO2kMbsqIYJBmTGvfPhzlWkL33kM9zPJX1kU'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 1, 'link_gambar' => 'https://fastly.picsum.photos/id/593/420/220.jpg?hmac=5cJ_-ytAO2kMbsqIYJBmTGvfPhzlWkL33kM9zPJX1kU'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],

        // Project 2
        ['project_id' => 2, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 2, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 2, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 2, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 2, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],

        // Project 3
        ['project_id' => 3, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 3, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 3, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 3, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 3, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],

        // Project 4
        ['project_id' => 4, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 4, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 4, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 4, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 4, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],

        // Project 5
        ['project_id' => 5, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 5, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 5, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 5, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 5, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
    ];

    private $comment = [
        [
            'user_id' => 1,
            'project_id' => 1,
            'isi_komen' => 'absen bang',
        ],
        [
            'user_id' => 2,
            'project_id' => 1,
            'isi_komen' => 'telat ga bang',
        ],
        [
            'user_id' => 3,
            'project_id' => 2,
            'isi_komen' => 'warnanya pas.',
        ],
        [
            'user_id' => 1,
            'project_id' => 2,
            'isi_komen' => 'aur auran',
        ],
        [
            'user_id' => 4,
            'project_id' => 3,
            'isi_komen' => 'emang gitu liriknya kocak',
        ],
        [
            'user_id' => 5,
            'project_id' => 3,
            'isi_komen' => 'sebut namaku bang',
        ],
        // Tambahkan data komentar lainnya sesuai kebutuhan

    ];
    private $like = [
        [
            'user_id' => 1,
            'project_id' => 1,
        ],
        [
            'user_id' => 2,
            'project_id' => 1,
        ],
        [
            'user_id' => 3,
            'project_id' => 2,
        ],
        [
            'user_id' => 1,
            'project_id' => 2,
        ],
        [
            'user_id' => 4,
            'project_id' => 3,
        ],
        [
            'user_id' => 5,
            'project_id' => 3,
        ],

    ];
    // public function run(): void
    // {
    //     foreach ($this->team as $value) {
    //         Team::create($value);
    //     }

    //     // 2. Seed data untuk tabel `anggota` (member)
    //     foreach ($this->anggota as $value) {
    //         Member::create($value);
    //     }

    //     // 3. Seed data untuk tabel `anggotaTeam` (team_member)
    //     foreach ($this->anggotaTeam as $value) {
    //         Team_member::create($value);
    //     }
    //     foreach($this->stakeholders as $key=> $value){
    //         Stakeholder::create($value);
    //     }
    //     foreach($this->proyek as $key=> $value){
    //         Project::create($value);
    //     }
    //     foreach($this->kategori as $key=> $value){
    //         Category::create($value);
    //     }
    //     foreach($this->kategori_proyek as $key=> $value){
    //         ProjectCategory::create($value);
    //     }
    //     foreach($this->tahun_proyek as $key=> $value){
    //         Year::create($value);
    //     }
    //     foreach($this->users as $key=> $value){
    //         $value["password"] = Hash::make($value["password"]);
    //         User::create($value);
    //     }
    //     foreach ($this->images as $key=>$value) {
    //         Image::create($value);
    //     }
    //     foreach ($this->comment as $key=>$value) {
    //         Comment::create($value);
    //     }
    //     foreach ($this->like as $key=>$value) {
    //         Like::create($value);
    //     }


    // }

    public function run()
{
    $this->call([
        TeamsSeeder::class,
        MembersSeeder::class,
        TeamMembersSeeder::class,
        StakeholdersSeeder::class,
        ProjectsSeeder::class,
        CategoriesSeeder::class,
        ProjectCategoriesSeeder::class,
        YearsSeeder::class,
        UsersSeeder::class,
        ImagesSeeder::class,
        CommentsSeeder::class,    
        LikesSeeder::class,
    ]);
}

}
