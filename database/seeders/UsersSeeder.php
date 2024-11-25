<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Muhammad Fakhrurrifqi',
                'email' => 'rifqi_ilkom@mail.ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'google_id' => null,
            ],
            [
                'name' => 'Irkham Huda',
                'email' => 'irkham@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'google_id' => null,
            ],
            [
                'name' => 'Imam Fahrurrozi',
                'email' => 'imam.fahrurrozi@ugm.ac.id',
                'password' => Hash::make('password123'),
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
            // Tambahkan data user lainnya
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
