<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable
{
  protected static function bootTaggable()
  {
    static::updating(fn ($model) => self::onUpdate($model));
    static::created(fn ($model) => self::onCreated($model));
  }

  protected static function onUpdate($model)
  {
    $model->tags()->sync(static::findTagsInContent($model->content));
  }

  protected static function onCreated($model)
  {
  }

  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable')
      ->withTimestamps()->as("tagged");
  }

  private static function findTagsInContent(string $content): Tag
  {
    preg_match_all('/@([^!#$%¨&*()-+=\[\]{}.@]+)@/gm', $content, $tags);

    return Tag::where('name', $tags[1] ?? [])->get();
  }
}
