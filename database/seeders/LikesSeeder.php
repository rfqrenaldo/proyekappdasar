<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    public function run()
    {
        $likes = [
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

        foreach ($likes as $like) {
            Like::create($like);
        }
    }
}
