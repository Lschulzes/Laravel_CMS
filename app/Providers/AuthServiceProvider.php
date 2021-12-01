<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\User;
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
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Gate::define('update-post', fn ($user, $post) => $this->canUpdatePost($user, $post));
    Gate::define('edit-post', fn ($user, $post) => $this->canEditPost($user, $post));
    Gate::define('delete-post', fn ($user, $post) => $this->canDeletePost($user, $post));
  }

  public function canUpdatePost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post);
  }

  public function canDeletePost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post);
  }

  public function canEditPost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post) || $this->isSuperAdmin($user, $post);
  }

  private function isPostAuthor(User $user, BlogPost $post): bool
  {
    return $user->id === $post->user->id ? true : false;
  }

  private function isSuperAdmin(User $user, BlogPost $post): bool
  {
    return $user->id === 1 ? true : false;
  }
}
