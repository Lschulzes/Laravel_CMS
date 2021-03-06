<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class LiveVisits
{
  private $sessionId;
  private $liveUsers = [];
  private $difference = 0;
  private $users = [];
  private $now;
  public function __construct(public string $counterKey, public string $usersKey)
  {
    $this->sessionId = session()->getId();
    $this->users = Cache::tags(['blog-post'])->get($usersKey, []);
  }

  public function getCount()
  {
    return $this->getLiveCounter();
  }

  private function getLiveCounter()
  {
    $this->updateCurrentTime();
    $this->updateLiveUsersAndCount();
    $this->handleCurrentUser();
    $this->updateLiveUsersCache();
    $this->handleCounterCache();

    return Cache::tags(['blog-post'])->get($this->counterKey);
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
    Cache::tags(['blog-post'])->put($this->usersKey, $this->liveUsers);
  }

  private function handleCounterCache(): void
  {
    if (!Cache::tags(['blog-post'])->has($this->counterKey)) Cache::tags(['blog-post'])->forever($this->counterKey, 1);
    else Cache::tags(['blog-post'])->increment($this->counterKey, $this->difference);
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
    return $this->now->diffInMinutes($lastVisitTime) >= Constants::LIVE_CACHE_TIME;
  }
}
