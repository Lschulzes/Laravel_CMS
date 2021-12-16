<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedMarkdown extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(public Comment $comment)
  {
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $subject = "Comment was posted on your post {$this->comment->commentable->title}";
    return $this->from("john@doe.com", "John Doe")
      // ->attach(
      //   $this->comment->user->image->path,
      //   ["as" => "profile_picture.jpeg", "mime" => "image/jpeg"]
      // )
      ->attachData($this->comment->user->image->path, "profile_pic.jpeg")
      ->subject($subject)
      ->markdown("emails.posts.commented-markdown");
  }
}
