<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Blade;
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
    User::observe(UserObserver::class);
    Blade::aliasComponent('components.badge', 'badge');
    Blade::aliasComponent('components.tags', 'tags');
    view()->composer('posts.partials._activity', ActivityComposer::class);
  }
}
