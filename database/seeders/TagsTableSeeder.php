<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $tags = collect(['Science', 'Sports', 'Politics', 'Entertainment', 'Economy']);
    $tags->each(function (string $tagName) {
      $tag = new Tag();
      $tag->name = $tagName;
      $tag->save();
    });
  }
}
