<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Post();
        $category->title = 'example-title';
        $category->slug = 'example-title-blog';
        $category->content = 'example-content-blog';
        $category->thumbnail = null;
        $category->category_id = 1;
        $category->user_id = 1;
        $category->save();
    }
}
