<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\User;

class UserCommentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function store(User $user, StoreComment $request)
  {
    $user->commentsOn()->create([
      'content' => $request->input('content'),
      'user_id' => $user->id
    ]);

    return redirect()->back()->with('status', 'Comment added successfully');
  }
}
