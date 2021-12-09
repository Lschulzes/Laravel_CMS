<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function store($postId, StoreComment $request)
  {
    $blogPost = BlogPost::find($postId);
    $blogPost->comments()->create([
      'content' => $request->input('content'),
      'user_id' => $request->user()->id
    ]);

    $request->session()->flash('status', 'Comment was created!');

    return redirect()->back();
  }
}
