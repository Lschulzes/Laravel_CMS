<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottleMail;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Mail\CommentPostedOnPostWatched;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function store(BlogPost $post, StoreComment $request)
  {
    $comment = $post->comments()->create([
      'content' => $request->input('content'),
      'user_id' => $request->user()->id
    ]);

    ThrottleMail::dispatch(new CommentPostedMarkdown($comment), $post->user);

    NotifyUsersPostWasCommented::dispatch($comment);

    return redirect()->back()->with('status', 'Comment was created!');
  }
}
