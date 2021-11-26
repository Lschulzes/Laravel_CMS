<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
  use RefreshDatabase;

  public function testNoBlogPostsWhenNothingInDB()
  {
    $response = $this->get('/posts');
    $response->assertSeeText('No blog posts yet!');
  }

  public function testSeeOneBlogPostWhenOne()
  {
    $post = new BlogPost();
    $post->title = 'New Title';
    $post->content = 'Content of the blog post';
    $post->save();
    $response = $this->get('/posts');

    $response->assertSeeText('New Title');
  }
}
