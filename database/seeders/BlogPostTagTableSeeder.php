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
    $amountOfTags = Tag::all()->count();
    if (0 === $amountOfTags) $this->command->info("No tags found to assign.");
    $howManyMin = (int)$this->command->ask('Minimum tags on blog post?', 0);
    $howManyMax = (int)min($this->command->ask('Maximum tags on blog post?', $amountOfTags), $amountOfTags);

    BlogPost::all()->each(function (BlogPost $bp) use ($howManyMax, $howManyMin) {
      $take = random_int($howManyMin, $howManyMax);
      $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
      $bp->tags()->sync($tags);
    });
  }
}
