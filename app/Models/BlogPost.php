<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
  protected $fillable = ['title', 'content', 'user_id'];
  use HasFactory;
  use SoftDeletes, Taggable;

  public function comments()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }



  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  public static function booted()
  {
    static::addGlobalScope(new DeletedAdminScope);
    parent::booted();
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
      ->withCount('comments')
      ->with(['user', 'tags']);
  }

  public function scopeSingleWithRelations(Builder $builder)
  {
    return $builder->with(['user', 'tags', 'comments', 'image']);
  }
}
