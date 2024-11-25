<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersSeeder extends Seeder
{
    public function run()
    {
        $members = [
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
        

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
