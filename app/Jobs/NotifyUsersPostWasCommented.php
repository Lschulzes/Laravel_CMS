<?php

namespace App\Jobs;

use App\Mail\CommentPostedOnPostWatched;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUsersPostWasCommented implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(public Comment $comment)
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    User::thatHasCommentOnPost($this->comment->commentable)
      ->get()
      ->filter(fn (User $user) => $user->id !== $this->comment->user_id)
      ->map(
        fn (User $user) => ThrottleMail::dispatch(new CommentPostedOnPostWatched($this->comment, $user), $user)
      );
  }
}
