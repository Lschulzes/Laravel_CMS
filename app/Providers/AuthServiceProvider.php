<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    'App\BlogPost' => 'App\Policies\BlogPostPolicy',
  ];
  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Gate::define('home.secret', fn ($user) => $user->is_admin);

    Gate::before(function ($user, $ability) {
      if ($user->is_admin && in_array($ability, ['delete', 'update'])) return true;
    });
  }
}
