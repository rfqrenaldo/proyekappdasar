<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        $comments = [
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

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
