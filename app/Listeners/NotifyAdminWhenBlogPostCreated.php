<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Jobs\ThrottleMail;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminWhenBlogPostCreated
{
  public function handle(BlogPostPosted $event)
  {
    User::adminUsers()->get()
      ->map(fn (User $user) => ThrottleMail::dispatch(
        new BlogPostAdded(),
        $user
      ));
  }
}
