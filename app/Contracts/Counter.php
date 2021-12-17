<?php

namespace App\Contracts;

interface Counter
{
  public function  getCount(string $key, array $tags = null);
}
