<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    if (!$this->command->confirm('Do you really want to refresh the DB?', true)) return;
    $this->command->call('migrate:refresh');
    $this->command->info("Database was refreshed!");

    Cache::tags(['blog-post'])->flush();

    $this->call([
      UsersTableSeeder::class,
      BlogPostsTableSeeder::class,
      CommentsTableSeeder::class
    ]);
  }
}
