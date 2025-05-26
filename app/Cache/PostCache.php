<?php

namespace App\Cache;

use App\Contracts\CacheInterface;
use Illuminate\Support\Facades\Cache;

class PostCache implements CacheInterface
{
    private string $prefix;
    private ?int $defaultTtl;

    public function __construct(string $prefix = 'posts_', ?int $defaultTtl = 3600)
    {
        $this->prefix = $prefix;
        $this->defaultTtl = $defaultTtl;
    }

    public function get(string $key, callable $callback, ?int $ttl = null): mixed
    {
        return Cache::remember(
            $this->getPrefixedKey($key),
            $this->getTtl($ttl),
            $callback
        );
    }

    public function forget(string $key): bool
    {
        return Cache::forget($this->getPrefixedKey($key));
    }

    // Add this new method to clear all post-related cache
    public function clearAllPostsCache(): void
    {
        $store = Cache::getStore();

        if (method_exists($store, 'getPrefix')) {

            $prefix = $store->getPrefix() . $this->prefix;

            $keys = $this->getAllCacheKeys($prefix);

            foreach ($keys as $key) {
                Cache::forget('posts_'.$key);
            }
        } else {
            // Fallback - clear all cache with our prefix
            Cache::flush();
        }
    }

    private function getAllCacheKeys(string $prefix): array
    {
        // Here's a Redis example:
        if (config('cache.default') === 'redis') {
            $redis = Cache::getRedis();
            $keys = $redis->keys($prefix . '*');
            return array_map(function ($key) {
                return str_replace(config('cache.prefix'), '', $key);
            }, $keys);
        }
        // when using file cache or other drivers, you might need to implement a different logic
        if (config('cache.default') === 'file') {
            $files = glob(storage_path('framework/cache/data/' . $prefix . '*'));
            return array_map('basename', $files);
        }
        // For database or other cache drivers, you might need to implement a different logic
        if (config('cache.default') === 'database') {
            $keys = \DB::table('cache')->where('key', 'like', $prefix . '%')->pluck('key')->toArray();
            return array_map(function ($key) use ($prefix) {
                return str_replace($prefix, '', $key);
            }, $keys);
        }

        // For other drivers that don't support key scanning
        return [];
    }

    public function flush(): bool
    {
        $this->clearAllPostsCache();
        return true;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    private function getPrefixedKey(string $key): string
    {
        return $this->prefix . $key;
    }

    private function getTtl(?int $ttl): int
    {
        return $ttl ?? $this->defaultTtl ?? 3600;
    }
}
