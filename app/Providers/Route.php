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
     * @return void
     */
    public function map(): void
    {
        $this->mapWeb();
        $this->mapApi();
    }

    /**
     * @return void
     */
    protected function mapWeb(): void
    {
        $this->mapLoadRouter('Controller');
    }

    /**
     * @return void
     */
    protected function mapApi(): void
    {
        Route::middleware('user-auth-api')
            ->name('api.')
            ->prefix('api')
            ->group(fn () => $this->mapLoadRouter('ControllerApi'));
    }

    /**
     * @param string $path
     *
     * @return void
     */
    protected function mapLoadRouter(string $path): void
    {
        foreach (glob(app_path('Domains/*/'.$path.'/router.php')) as $file) {
            require $file;
        }
    }
}
