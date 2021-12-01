<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
    $this->call(UsersTableSeeder::class)
      ->call(BlogPostsTableSeeder::class)
      ->call(CommentsTableSeeder::class);
  }
}
