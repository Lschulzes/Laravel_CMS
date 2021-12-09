<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $tags = Tag::all();
    $blogPosts = BlogPost::all();
    $blogPosts->each(function (BlogPost $bp) use ($tags) {
      $bp->tags()->sync($tags->random());
    });
  }
}
