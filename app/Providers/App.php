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
        $this->locale();
        $this->language();
        $this->configuration();
    }

    /**
     * @return void
     */
    protected function locale(): void
    {
        $locale = config('app.locale');

        if (str_contains($locale, '_')) {
            return;
        }

        $new = match ($locale) {
            'en' => 'en_US',
            'pt' => 'pt_BR',
            'he' => 'he_IL',
            'ar' => 'ar_AE',
            default => $locale.'_'.strtoupper($locale),
        };

        trigger_error(sprintf('Configure APP_LOCALE as "%s", currently is "%s"', $new, $locale), E_USER_DEPRECATED);

        config(['app.locale' => $new]);
    }

    /**
     * @return void
     */
    protected function language(): void
    {
        $this->factory('Language')->action()->set();
    }

    /**
     * @return void
     */
    protected function configuration(): void
    {
        $this->factory('Configuration')->action()->appBind();
    }
}
