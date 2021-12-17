<?php

namespace App\Facades;

use App\Contracts\Counter as ContractsCounter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static int getCount(string $key, array $tags = null)
 */
class Counter extends Facade
{
  public static function getFacadeAccessor()
  {
    return ContractsCounter::class;
  }
}
