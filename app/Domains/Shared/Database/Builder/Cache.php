<?php declare(strict_types=1);

namespace App\Domains\Shared\Database\Builder;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Query\Builder;

class Cache extends Builder
{
    /**
     * @var array
     */
    protected array $cacheConfig;

    /**
     * @return array
     */
    protected function runSelect()
    {
        return $this->cacheResult(fn () => parent::runSelect());
    }

    /**
     * @param ?int $ttl = null
     *
     * @return self
     */
    public function cache(?int $ttl = null): self
    {
        if ($ttl !== null) {
            $this->cacheConfig('ttl', $ttl);
        }

        return $this;
    }

    /**
     * @param callable $result
     *
     * @return array
     */
    protected function cacheResult(callable $result): array
    {
        if ($this->cacheEnabled() === false) {
            return $result();
        }

        return $this->cacheManager()->remember($this->cacheKey(), $this->cacheTtl(), $result);
    }

    /**
     * @return bool
     */
    protected function cacheEnabled(): bool
    {
        return $this->cacheConfig('enabled') && $this->cacheConfig('ttl');
    }

    /**
     * @param ?string $key = null
     * @param string|int|bool|null $value = null
     *
     * @return mixed
     */
    protected function cacheConfig(?string $key = null, string|int|bool|null $value = null): mixed
    {
        $this->cacheConfig ??= $this->cacheConfigDefault();

        if ($value !== null) {
            return $this->cacheConfig[$key] = $value;
        }

        if ($key === null) {
            return $this->cacheConfig;
        }

        return $this->cacheConfig[$key] ?? null;
    }

    /**
     * @return array
     */
    protected function cacheConfigDefault(): array
    {
        static $config;

        return $config ??= config('database.cache', []) + [
            'enabled' => false,
            'driver' => 'redis',
            'ttl' => 3600,
            'tag' => 'database',
            'prefix' => 'database|',
        ];
    }

    /**
     * @return string
     */
    protected function cacheKey(): string
    {
        return $this->cacheConfig('prefix').md5($this->toSql().'|'.serialize($this->getBindings()));
    }

    /**
     * @return int
     */
    protected function cacheTtl(): int
    {
        return (int)$this->cacheConfig('ttl');
    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function cacheManager(): Repository
    {
        $repository = $this->cacheRepository();

        if ($repository->supportsTags() && $this->cacheTagGlobal()) {
            $repository = $repository->tags($this->cacheTags());
        }

        return $repository;
    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function cacheRepository(): Repository
    {
        static $repository;

        return $repository ??= resolve('cache')->store($this->cacheConfig('driver'));
    }

    /**
     * @return array
     */
    protected function cacheTags(): array
    {
        return array_filter([$this->cacheTagGlobal(), $this->cacheTagPrefix()]);
    }

    /**
     * @return ?string
     */
    protected function cacheTagGlobal(): ?string
    {
        return $this->cacheConfig('tag');
    }

    /**
     * @return ?string
     */
    protected function cacheTagPrefix(): ?string
    {
        if ($this->from) {
            return $this->cacheTagGlobal().'|'.$this->from;
        }

        return null;
    }
}
