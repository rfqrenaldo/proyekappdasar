<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategoriesSeeder extends Seeder
{
    public function run()
    {
        $projectCategories = [
            ['id' => 1, 'project_id' => 1, 'category_id' => 1],
            ['id' => 2, 'project_id' => 2, 'category_id' => 1],
            ['id' => 3, 'project_id' => 3, 'category_id' => 2],
            ['id' => 4, 'project_id' => 4, 'category_id' => 2],
            ['id' => 5, 'project_id' => 5, 'category_id' => 1],
        ];

        foreach ($projectCategories as $projectCategory) {
            ProjectCategory::create($projectCategory);
        }
    }
}
