<?php

namespace App\Observers;

use App\Helpers\Constants;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
  /**
   * Handle the User "created" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function created(User $user)
  {
    Cache::put("user.{$user->id}", $user, Constants::DEFAULT_CACHE_TIME);
  }

  /**
   * Handle the User "updated" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function updated(User $user)
  {
    Cache::put("user.{$user->id}", $user, Constants::DEFAULT_CACHE_TIME);
  }

  /**
   * Handle the User "deleted" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function deleted(User $user)
  {
    Cache::forget("user.{$user->id}");
  }

  /**
   * Handle the User "restored" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function restored(User $user)
  {
    Cache::add("user.{$user->id}", $user, Constants::DEFAULT_CACHE_TIME);
  }

  /**
   * Handle the User "force deleted" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function forceDeleted(User $user)
  {
    Cache::forget("user.{$user->id}");
  }
}
