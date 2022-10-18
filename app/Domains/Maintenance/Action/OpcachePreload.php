<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Service\OPcache\Preloader;

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
        return (new Preloader(base_path('')))
            ->paths(
                base_path('app'),
                base_path('vendor/laravel'),
            )
            ->ignore(
                'Illuminate\Http\Testing',
                'Illuminate\Filesystem\Cache',
                'Illuminate\Foundation\Testing',
                'Illuminate\Testing',
                'Laravel\Octane',
                'PHPUnit',
                'Swoole',
                'Tests',
                '/App\\\Domains\\\[^\\\]+\\\Test/',
            )
            ->load()
            ->log();
    }
}
