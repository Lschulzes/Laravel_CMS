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

class Comment extends Model
{
  use SoftDeletes, Taggable, HasFactory;

  protected $fillable = ['user_id', 'content'];

  protected $hidden = [
    'commentable_type',
    'commentable_id',
    'deleted_at',
    'user_id'
  ];

  public static function booted()
  {
    static::addGlobalScope(new DeletedAdminScope);
    static::addGlobalScope(new LatestScope);
    parent::booted();
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
}
