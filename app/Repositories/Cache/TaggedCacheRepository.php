<?php

declare(strict_types=1);

namespace App\Repositories\Cache;

use App\Contracts\CachedRepositoryContract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

abstract class TaggedCacheRepository implements CachedRepositoryContract
{
    public array $tags;

    protected TaggedCache $cache;

    public function __construct()
    {
        $this->cache = Cache::tags($this->tags);
    }

    /** @inheritDoc */
    public function clearCache(): bool
    {
        return $this->cache->flush();
    }
}
