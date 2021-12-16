<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
  public function deleting(BlogPost $blogPost)
  {
    $blogPost->image()->delete();
    $blogPost->comments()->delete();
    Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
  }

  public function updating(BlogPost $blogPost)
  {
    Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
  }

  public function restoring(BlogPost $blogPost)
  {
    $blogPost->comments()->restore();
  }

  public function creating(BlogPost $blogPost)
  {
    Cache::tags(['blog-post'])->clear();
  }
}
