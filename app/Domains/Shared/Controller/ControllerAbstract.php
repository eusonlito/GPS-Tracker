<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @param string $slug
     *
     * @return void
     */
    protected function publicIsAvailable(string $slug): void
    {
        if ($this->publicIsAvailableCheck($slug) === false) {
            abort(404);
        }
    }

    /**
     * @param string $slug
     *
     * @return bool
     */
    protected function publicIsAvailableCheck(string $slug): bool
    {
        $configuration = app('configuration');

        return $configuration->bool('shared_enabled')
            && ($configuration->string('shared_slug') === $slug);
    }
}
