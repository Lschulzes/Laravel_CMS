<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = ['user_id', 'content'];

  public static function boot()
  {
    static::addGlobalScope(new DeletedAdminScope);
    parent::boot();
    static::creating(fn (Comment $comment) => self::onCreation($comment));
  }

  public static function onCreation(Comment $comment)
  {
    if ($comment->commentable_type === BlogPost::class) {
      Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
      Cache::tags(['blog-post'])->forget("mostCommented");
    }
  }

  public function scopeLatest(Builder $query)
  {
    return $query->orderBy(static::CREATED_AT, 'desc');
  }

  public function commentable()
  {
    return $this->morphTo();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable')
      ->withTimestamps()
      ->as('tagged');
  }
}
