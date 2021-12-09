<?php

namespace App\Http\ViewComposers;

use App\Helpers\Constants;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
  public function compose(View $view)
  {
    $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-most-commented', Constants::DEFAULT_CACHE_TIME, fn () => BlogPost::mostComments()->take(5)->get());

    $mostActiveLastMonth = Cache::tags(['blog-post'])->remember('user-most-active-last-month', Constants::DEFAULT_CACHE_TIME, fn () => User::withMostBlogPostsLastMonth()->with('blogPosts')->take(5)->get());

    $view->with('mostCommented', $mostCommented);
    $view->with('mostActiveLastMonth', $mostActiveLastMonth);
  }
}
