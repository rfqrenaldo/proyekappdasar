<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            ],
            [
                'name' => 'Irkham Huda',
                'email' => 'irkham@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Imam Fahrurrozi',
                'email' => 'imam.fahrurrozi@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Firma Syahrian',
                'email' => 'fsyahrian@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Divi Galih Prasetyo Putri',
                'email' => 'divi.galih@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Yusron Fuadi',
                'email' => 'yusron.fuadi@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Anindita Suryarasmi',
                'email' => 'anindita@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Umar Taufiq',
                'email' => 'umartaufiq8284@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Airlangga Adi Hermawan',
                'email' => 'airlangga.adi.hermawan@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Dinar Nugroho Pratomo',
                'email' => 'dinar.nugroho.p@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Ganjar Alfian',
                'email' => 'ganjar.alfian@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Rochana Prih Hastuti',
                'email' => 'rochana.prih.h@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Margareta Hardiyanti',
                'email' => 'margareta.hardiyanti@ugm.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Syafiq Abdillah',
                'email' => 'syafiq.abdillah@ugm.ac.id',
                'password' => Hash::make('adminpassword'),
                'role' => 'admin',
            ],
            // Tambahkan user lain jika perlu
        ];

        foreach ($users as $user) {
            $emailWithoutDomain = explode('@', $user['email'])[0];
            $user['google_id'] = $emailWithoutDomain . '_' . Str::random(6);
            $user['google_token'] = Str::random(40); // <= ini WAJIB supaya error hilang
            User::create($user);
        }

    
    }
}
