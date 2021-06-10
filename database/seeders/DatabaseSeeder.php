<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
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
            'name' => 'Category 1'
        ]);
        Category::factory()->create([
            'name' => 'Category 2'
        ]);
        Category::factory()->create([
            'name' => 'Category 3'
        ]);
        Category::factory()->create([
            'name' => 'Category 4'
        ]);
        Category::factory()->create([
            'name' => 'Category 5'
        ]);
        Post::factory(100)->create();
    }
}
