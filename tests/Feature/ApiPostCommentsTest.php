<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
  use RefreshDatabase;

  public function testNewBlogPostDoesNotHaveComments()
  {
    BlogPost::factory(1)->make()->each(function ($post) {
      $post->user_id = $this->user()->id;
      $post->save();
    });

    $response = $this->json('GET', 'api/v1/posts/1/comments');
    $response->assertStatus(200)
      ->assertJsonStructure(['data', 'links', 'meta'])
      ->assertJsonCount(0, 'data');
  }

  public function testBlogPostHas10Comments()
  {
    $this->blogPost();
    $post = BlogPost::find(2);
    Comment::factory(10)->make()->each(function (Comment $comment) use ($post) {
      $comment->commentable_id = $post->id;
      $comment->commentable_type = BlogPost::class;
      $comment->user_id = $post->user->id;
      $comment->save();
    });
    $response = $this->json('GET', 'api/v1/posts/2/comments');
    $response->assertStatus(200)
      ->assertJsonStructure([
        'data' => [
          "*" => [
            "comment_id",
            "content",
            "created_at",
            "updated_at",
            "user" => [
              "id",
              "name",
            ]
          ]
        ],
        'links',
        'meta'
      ])
      ->assertJsonCount(10, 'data');
  }

  public function testAddingCommentsWhenNotAuthenticated()
  {
    $this->blogPost();
    $response = $this->json('POST', 'api/v1/posts/3/comments', [
      'content' => "Hello!",
    ]);

    $response->assertStatus(401);
  }
}
