<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $posts = BlogPost::all();
    if ($posts->count() < 1) {
      $this->command->info('There are no Blog Posts To Add a Comment To');
      return;
    }
    $commentCount = (int)$this->command->ask('Comments qty', 3000);
    Comment::factory($commentCount)->make()->each(function ($comment) use ($posts) {
      $comment->blog_post_id = $posts->random()->id;
      $comment->save();
    });
  }
}