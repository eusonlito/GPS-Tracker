<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Core\Traits\Factory;

class App extends ServiceProvider
{
    use Factory;

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->configuration();
    }

    /**
     * @return void
     */
    protected function locale(): void
    {
        $locale = config('app.locale');

        setlocale(LC_COLLATE, $locale);
        setlocale(LC_CTYPE, $locale);
        setlocale(LC_MONETARY, $locale);
        setlocale(LC_TIME, $locale);

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $locale);
        }
    }

    /**
     * @return void
     */
    protected function configuration(): void
    {
        $this->factory('Configuration')->action()->appBind();
    }
}
