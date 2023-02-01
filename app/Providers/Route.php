<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;

class Route extends RouteServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->patterns();

        parent::boot();
    }

    /**
     * @return void
     */
    protected function patterns(): void
    {
        RouteFacade::pattern('id', '[0-9]+');
        RouteFacade::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        foreach (glob(app_path('Domains/*/Controller*/router.php')) as $file) {
            require $file;
        }
    }
}
