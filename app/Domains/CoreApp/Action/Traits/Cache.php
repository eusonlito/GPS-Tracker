<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Action\Traits;

use Illuminate\Contracts\Cache\Repository;

trait Cache
{
    /**
     * @return void
     */
    protected function cacheClear(): void
    {
        if ($this->cacheClearEnabled()) {
            $this->cacheClearManager()->flush();
        }
    }

    /**
     * @param string $tag
     *
     * @return void
     */
    protected function cacheClearTag(string $tag): void
    {
        if ($this->cacheClearEnabled()) {
            $this->cacheClearManager($tag)->flush();
        }
    }

    /**
     * @return bool
     */
    protected function cacheClearEnabled(): bool
    {
        return $this->cacheClearConfig('enabled')
            && $this->cacheClearConfig('ttl');
    }

    /**
     * @param ?string $tag = null
     *
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function cacheClearManager(?string $tag = null): Repository
    {
        $repository = $this->cacheClearRepository();

        if ($repository->supportsTags() === false) {
            return $repository;
        }

        return $repository->tags(implode('|', array_filter([$this->cacheClearTagGlobal(), $tag])));
    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function cacheClearRepository(): Repository
    {
        static $repository;

        return $repository ??= resolve('cache')->store($this->cacheClearConfig('driver'));
    }

    /**
     * @return string
     */
    protected function cacheClearTagGlobal(): string
    {
        return $this->cacheClearConfig('tag');
    }

    /**
     * @param ?string $key = null
     *
     * @return mixed
     */
    protected function cacheClearConfig(?string $key = null): mixed
    {
        return $this->cacheClearConfigDefault()[$key] ?? null;
    }

    /**
     * @return array
     */
    protected function cacheClearConfigDefault(): array
    {
        static $config;

        return $config ??= config('database-cache', []) + [
            'enabled' => false,
            'driver' => 'redis',
            'ttl' => 3600,
            'tag' => 'database',
            'prefix' => 'database|',
        ];
    }
}
