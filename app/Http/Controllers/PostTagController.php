<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostTagController extends Controller
{

  public function index($tagID)
  {
    $blogPosts = Cache::tags(['blog-post'])->remember("tag-{$tagID}-blog-posts", 60, fn () => $this->getPostsByTagId($tagID));

    return view('posts.index', ['posts' => $blogPosts]);
  }

  public function getPostsByTagId($tagID)
  {
    return Tag::findOrFail($tagID)
      ->blogPosts()
      ->mostCommentsWithRelations()
      ->get();
  }
}
