<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

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
