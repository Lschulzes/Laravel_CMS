<?php

namespace App\Services;

use App\Contracts\Counter as ContractsCounter;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Session\Session;
use Carbon\Carbon;

class Counter implements ContractsCounter
{
  private $counterKey;
  private $usersKey;
  private $sessionId;
  private $liveUsers = [];
  private $difference = 0;
  private $users = [];
  private $now;
  private $supportsTags;

  public function __construct(private Cache $cache, private Session $session, private int $timeout = 60)
  {
    $this->supportsTags = method_exists($cache, 'tags');
  }


  public function getCount(string $key, array $tags = null)
  {
    $this->usersKey = $key . "-users";
    $this->counterKey = $key . "-counter";
    $this->cache = $this->supportsTags && null !== $tags ? $this->cache->tags($tags) : $this->cache;
    $this->sessionId = $this->session->getId();
    $this->users = $this->cache->get($this->usersKey, []);
    return $this->getLiveCounter();
  }

  private function getLiveCounter()
  {
    $this->updateCurrentTime();
    $this->updateLiveUsersAndCount();
    $this->handleCurrentUser();
    $this->updateLiveUsersCache();
    $this->handleCounterCache();

    return $this->cache->get($this->counterKey);
  }

  private function updateCurrentTime(): void
  {
    $this->now = now();
  }

  private function updateLiveUsersAndCount(): void
  {
    foreach ($this->users as $session => $lastVisitTime) {
      if ($this->isUserVisitNoLongerAccountedFor($lastVisitTime)) $this->difference--;
      else $this->liveUsers[$session] = $lastVisitTime;
    }
  }

  private function updateLiveUsersCache(): void
  {
    $this->cache->put($this->usersKey, $this->liveUsers);
  }

  private function handleCounterCache(): void
  {
    if (!$this->cache->has($this->counterKey)) $this->cache->forever($this->counterKey, 1);
    else $this->cache->increment($this->counterKey, $this->difference);
  }

  private function handleCurrentUser(): void
  {
    if (
      !array_key_exists($this->sessionId, $this->users)
      || $this->isUserVisitNoLongerAccountedFor($this->users[$this->sessionId])
    ) $this->difference++;

    $this->liveUsers[$this->sessionId] = $this->now;
  }

  private function isUserVisitNoLongerAccountedFor(Carbon $lastVisitTime): bool
  {
    return $this->now->diffInMinutes($lastVisitTime) >= $this->timeout;
  }
}
