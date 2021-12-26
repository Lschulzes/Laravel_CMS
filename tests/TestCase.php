<?php

namespace Tests;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  protected function user()
  {
    return User::factory()->predefinedState()->create();
  }

  protected function blogPost()
  {
    return BlogPost::factory(1)->make()->each(function (BlogPost $post) {
      $post->user_id = $this->user()->id;
      $post->save();
    })[0];
  }
}
