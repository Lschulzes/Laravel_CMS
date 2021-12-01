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

    // Gate::define('update-post', fn ($user, $post) => $this->canUpdatePost($user, $post));
    // Gate::define('edit-post', fn ($user, $post) => $this->canEditPost($user, $post));
    // Gate::define('delete-post', fn ($user, $post) => $this->canDeletePost($user, $post));
    // Gate::before(fn ($user, $ability) => $this->adminHasAbility($user, $ability));

    // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
    // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

    Gate::resource('posts', 'App\Policies\BlogPostPolicy');
  }

  protected function canUpdatePost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post);
  }

  protected function canDeletePost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post);
  }

  protected function canEditPost(User $user, BlogPost $post)
  {
    return $this->isPostAuthor($user, $post);
  }

  private function isPostAuthor(User $user, BlogPost $post): bool
  {
    return $user->id === $post->user->id ? true : false;
  }

  private function adminHasAbility(User $user, $ability): bool
  {
    return $user->is_admin && in_array($ability, ['posts.update', 'posts.delete']);
  }
}
