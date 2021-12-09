<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
  use HasFactory;
  use SoftDeletes;

  public static function boot()
  {
    static::addGlobalScope(new DeletedAdminScope);
    parent::boot();
  }

  public function scopeLatest(Builder $query)
  {
    return $query->orderBy(static::CREATED_AT, 'desc');
  }

  public function blogPost()
  {
    return $this->belongsTo('App\Models\BlogPost');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
