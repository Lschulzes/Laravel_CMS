<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{

  public function index($tagID)
  {
    $tag = Tag::findOrFail($tagID);
    return view('posts.index', ['posts' => $tag->blogPosts]);
  }
}
