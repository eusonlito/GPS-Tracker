<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use App\Domains\CoreMaintenance\Service\OPcache\Preloader;

class OpcachePreload extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->preload();
    }

    /**
     * @return array
     */
    protected function preload(): array
    {
        return (new Preloader($this->base()))
            ->paths(...$this->paths())
            ->ignore(...$this->ignore())
            ->load()
            ->log();
    }

    /**
     * @return string
     */
    protected function base(): string
    {
        return base_path('');
    }

    /**
     * @return array
     */
    protected function paths(): array
    {
        return [
            base_path('app'),
            base_path('vendor/laravel'),
        ];
    }

    /**
     * @return array
     */
    protected function ignore(): array
    {
        return [
            'Illuminate\Http\Testing',
            'Illuminate\Filesystem\Cache',
            'Illuminate\Foundation\Testing',
            'Illuminate\Testing',
            'Laravel\Octane',
            'PHPUnit',
            'Swoole',
            'Tests',
            '/App\\\Domains\\\[^\\\]+\\\Test/',
        ];
    }
}
