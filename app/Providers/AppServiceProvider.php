<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\User;
use App\Observers\UserObserver;
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
    Schema::defaultStringLength(180);
    User::observe(UserObserver::class);
    Blade::aliasComponent('components.badge', 'badge');
    Blade::aliasComponent('components.tags', 'tags');
    Blade::aliasComponent('components.errors', 'errors');
    view()->composer('posts.partials._activity', ActivityComposer::class);
  }
}
