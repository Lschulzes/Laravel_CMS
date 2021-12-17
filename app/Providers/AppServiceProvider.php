<?php

namespace App\Providers;

use App\Contracts\Counter as ContractsCounter;
use App\Helpers\Constants;
use App\Http\ViewComposers\ActivityComposer;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Observers\UserObserver;
use App\Services\Counter;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->handleDatabase();
    $this->handleObservers();
    $this->handleViews();
    $this->handleDependencies();
  }

  private function handleDatabase()
  {
    Schema::defaultStringLength(180);
  }

  private function handleObservers()
  {
    User::observe(UserObserver::class);
    BlogPost::observe(BlogPostObserver::class);
    Comment::observe(CommentObserver::class);
  }

  private function handleViews()
  {
    Blade::aliasComponent('components.badge', 'badge');
    Blade::aliasComponent('components.tags', 'tags');
    Blade::aliasComponent('components.errors', 'errors');
    Blade::aliasComponent('components.comment-form', 'commentForm');
    Blade::aliasComponent('components.comment-list', 'commentList');
    view()->composer('posts.partials._activity', ActivityComposer::class);
  }

  private function handleDependencies()
  {
    $this->app->singleton(
      Counter::class,
      fn ($app) => new Counter(
        $app->make(Repository::class),
        $app->make(Session::class),
        Constants::LIVE_CACHE_TIME
      )
    );

    $this->app->bind(ContractsCounter::class, Counter::class);
  }
}
