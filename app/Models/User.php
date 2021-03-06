<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  public const LOCALES = [
    "en" => "English",
    "es" => "Español",
    "de" => "Deutsch",
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'email_verified_at',
    'created_at',
    'updated_at',
    'is_admin',
    'locale',
    'email'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function blogPosts()
  {
    return $this->hasMany(BlogPost::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }


  public function commentsOn()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }

  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  public function scopeWithMostBlogPosts(Builder $query)
  {
    return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
  }

  public function scopeThatHasCommentOnPost(Builder $builder, BlogPost $blogPost)
  {
    return $builder->whereHas(
      'comments',
      fn ($query) => $query
        ->where("commentable_id", '=', $blogPost->id)
        ->where("commentable_type", "=", BlogPost::class)
    );
  }

  public function scopeAdminUsers(Builder $builder): Builder
  {
    return $builder->where('is_admin', true);
  }

  public function scopeWithMostBlogPostsLastMonth(Builder $query)
  {
    return $query->withCount([
      'blogPosts' => fn (Builder $query) => $query
        ->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()])
    ])
      ->having('blog_posts_count', '>=', 3)
      ->orderBy('blog_posts_count', 'desc');
  }
}
