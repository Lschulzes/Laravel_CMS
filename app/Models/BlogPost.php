<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
  protected $fillable = ['title', 'content', 'user_id'];
  use HasFactory;
  use SoftDeletes;

  public function comments()
  {
    return $this->hasMany('App\Models\Comment');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }

  public function tags()
  {
    return $this->belongsToMany('App\Models\Tag')
      ->withTimestamps()
      ->as('tagged');
  }

  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  public static function boot()
  {
    static::addGlobalScope(new DeletedAdminScope);
    parent::boot();
    static::deleting(fn (BlogPost $post) => self::onDelete($post));
    static::restoring(fn (BlogPost $post) => self::onRestore($post));
    static::updating(fn (BlogPost $post) => self::onUpdating($post));
  }

  public function scopeLatest(Builder $query)
  {
    return $query->orderBy(static::CREATED_AT, 'desc');
  }

  public function scopeMostComments(Builder $query)
  {
    return $query->withCount('comments')->orderBy('comments_count', 'desc');
  }

  public function scopeMostCommentsWithRelations(Builder $builder)
  {
    return $builder
      ->mostComments()
      ->latest()
      ->withCount('comments')
      ->with(['user', 'tags']);
  }

  public function scopeSingleWithRelations(Builder $builder)
  {
    return $builder->with(['user', 'tags', 'comments', 'image']);
  }

  public static function onDelete(BlogPost $post)
  {
    $post->image()->delete();
    $post->comments()->delete();
  }

  public static function onRestore(BlogPost $post)
  {
    $post->comments()->delete();
  }

  public static function onUpdating(BlogPost $post)
  {
    Cache::tags(['blog-post'])->forget("blog-post-{$post->id}");
  }
}
