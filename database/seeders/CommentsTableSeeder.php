<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
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
    $users = User::all();
    if ($posts->count() < 1) {
      $this->command->info('There are no Blog Posts To Add a Comment To');
      return;
    }
    $commentCount = (int)$this->command->ask('Comments qty', 500);
    Comment::factory($commentCount)->make()->each(function ($comment) use ($posts, $users) {
      $comment->commentable_id = $posts->random()->id;
      $comment->commentable_type = BlogPost::class;
      $comment->user_id = $users->random()->id;
      $comment->save();
    });
  }
}
