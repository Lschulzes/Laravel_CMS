<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
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

  public function testSeeOneBlogPostWhenOneWithoutComments()
  {
    $post = $this->createDummyBlogPost();
    $response = $this->get('/posts');

    $response->assertSeeText('New Title');

    $response->assertSeeText('No Comments');

    $this->assertDatabaseHas('blog_posts', [
      'title' => 'New Title',
      'content' => 'Content of the blog post',
    ]);
  }

  public function testSee1BlogPostWithComments()
  {
    $post = $this->createDummyBlogPost();
    Comment::factory(7)->create(['blog_post_id' => $post->id]);
    $response = $this->get('/posts');
    $response->assertSeeText('Comments(7)');
  }

  public function testStoreFail()
  {
    $params = [
      'title' => "",
      'content' => ''
    ];

    $this->actingAs($this->user())
      ->post('/posts', $params)
      ->assertStatus(302)
      ->assertSessionHas('errors');

    $messages = session('errors')->getMessages();

    $this->assertEquals($messages['title'][0], "The title must be at least 5 characters.");
    $this->assertEquals($messages['content'][0], "The content must be at least 10 characters.");
  }

  public function testStoreValid()
  {
    $params = [
      'title' => "Valid title",
      'content' => 'At least 10 chars'
    ];

    $this->actingAs($this->user())
      ->post('/posts', $params)
      ->assertStatus(302)
      ->assertSessionHas('status');

    $this->assertEquals(session('status'), 'The Blog Post Was Created!');
  }

  public function testUpdateValid()
  {
    $post = $this->createDummyBlogPost();

    $this->assertDatabaseHas('blog_posts', [
      'title' => 'New Title',
      'content' => 'Content of the blog post'
    ]);

    $params = [
      'title' => 'Some other title',
      'content' => 'Some other content',
    ];

    $this->actingAs($this->user())
      ->put("/posts/{$post->id}", $params)
      ->assertStatus(302)
      ->assertSessionHas('status');

    $this->assertEquals(session('status'), 'Blog post Updated successfully');

    $this->assertDatabaseMissing('blog_posts', $post->toArray());
    $this->assertDatabaseHas('blog_posts', $params);
  }

  public function testDelete()
  {

    $post = $this->createDummyBlogPost();


    $this->assertDatabaseHas('blog_posts', [
      'title' => 'New Title',
      'content' => 'Content of the blog post'
    ]);

    $this->assertDatabaseHas('blog_posts', [
      'title' => 'New Title',
      'content' => 'Content of the blog post'
    ]);

    $this->actingAs($this->user())
      ->delete("/posts/{$post->id}")
      ->assertStatus(302)
      ->assertSessionHas('status');

    $this->assertEquals(session('status'), "Blog post Deleted successfully");

    $this->assertSoftDeleted('blog_posts', [
      'title' => $post->toArray()['title'],
      'content' => $post->toArray()['content']
    ]);
  }

  private function createDummyBlogPost(): BlogPost
  {
    $state = [];
    $state['title'] = 'New Title';
    $state['content'] = 'Content of the blog post';
    return BlogPost::factory()->determineData($state)->create();
  }
}
