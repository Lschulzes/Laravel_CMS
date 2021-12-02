<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

  public static function boot()
  {
    parent::boot();
    static::deleting(fn (BlogPost $post) => self::onDelete($post));
    static::restoring(fn (BlogPost $post) => self::onRestore($post));
    static::addGlobalScope(new LatestScope);
  }

  public static function onDelete(BlogPost $post)
  {
    $post->comments()->delete();
  }

  public static function  onRestore(BlogPost $post)
  {
    $post->comments()->delete();
  }
}
