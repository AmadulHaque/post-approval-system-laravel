<?php

namespace App\Contracts;

interface CacheInterface
{
    public function get(string $key, callable $callback, ?int $ttl = null): mixed;
    public function forget(string $key): bool;
    public function flush(): bool;
    public function getPrefix(): string;
}
