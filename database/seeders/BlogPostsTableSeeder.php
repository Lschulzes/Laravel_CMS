<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $postsCount = max((int)$this->command->ask('BlogPosts Quantity', 100), 1);
    $users = User::all();
    BlogPost::factory($postsCount)->make()->each(function ($post) use ($users) {
      $post->user_id = $users->random()->id;
      $post->save();
    });
  }
}
