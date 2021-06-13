<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        Category::factory()->create([
            'name' => 'Personal'
        ]);
        Category::factory()->create([
            'name' => 'Work'
        ]);
        Category::factory()->create([
            'name' => 'Sports'
        ]);
        Category::factory()->create([
            'name' => 'Movies'
        ]);
        Category::factory()->create([
            'name' => 'Laravel'
        ]);
        Post::factory(100)->create();
        Comment::factory(400)->create();
    }
}
