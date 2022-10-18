<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class App extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->locale();
    }

    /**
     * @return void
     */
    protected function locale(): void
    {
        $locale = config('app.locale_system')[config('app.locale')];

        setlocale(LC_COLLATE, $locale);
        setlocale(LC_CTYPE, $locale);
        setlocale(LC_MONETARY, $locale);
        setlocale(LC_TIME, $locale);

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $locale);
        }
    }
}
