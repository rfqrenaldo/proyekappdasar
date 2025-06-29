<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['id' => 1, 'nama_kategori' => 'PAD1'],
            ['id' => 2, 'nama_kategori' => 'PAD2'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
