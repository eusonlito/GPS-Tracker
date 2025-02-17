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
        $this->language();
    }

    /**
     * @return void
     */
    protected function configuration(): void
    {
        $this->factory('Configuration')->action()->appBind();
    }

    /**
     * @return void
     */
    protected function language(): void
    {
        $this->factory('Language')->action()->set();
    }
}
