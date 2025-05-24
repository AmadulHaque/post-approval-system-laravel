<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'role' =>  1, // Assuming 1 is the role for admin
        ]);

        Category::factory(10)->create();
        Tag::factory(10)->create();

        User::factory()
            ->count(5)
            ->has(
                Post::factory()
                    ->count(4)
                    ->afterCreating(function ($post) {
                        $post->categories()->attach(
                            Category::inRandomOrder()->limit(rand(1, 10))->pluck('id')->toArray()
                        );

                        $post->tags()->attach(
                            Tag::inRandomOrder()->limit(rand(1, 10))->pluck('id')->toArray()
                        );
                    })
            )
            ->create();


    }
}
