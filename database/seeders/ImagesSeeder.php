<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    public function run()
    {
        $images = [
            // Project 1
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
        ['project_id' => 1, 'link_gambar' => 'https://tse1.mm.bing.net/th?id=OIP.YCjPRaOLipkncsvEibKS6QHaD4&pid=Api&P=0&h=220'],
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


        foreach ($images as $image) {
            Image::create($image);
        }
    }
}
