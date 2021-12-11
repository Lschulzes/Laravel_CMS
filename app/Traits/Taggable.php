<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait Taggable
{
  protected static function bootTaggable()
  {
    static::updating(fn ($model) => self::onUpdate($model));
    static::created(fn ($model) => self::onCreated($model));
  }

  protected static function onUpdate(Model $model)
  {
    self::getTagsFromContent($model);
  }

  protected static function onCreated($model)
  {
    self::getTagsFromContent($model);
  }

  protected static function getTagsFromContent($model)
  {
    $model->tags()->sync(static::findTagsInContent($model->content));
  }

  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable')
      ->withTimestamps()->as("tagged");
  }

  private static function findTagsInContent(string $content): Collection
  {
    preg_match_all('/@([^!#$%¨&*()-+=\[\]{}.@]+)@/m', $content, $tags);
    return Tag::whereIn('name', $tags[1] ?? [])->get();
  }
}
