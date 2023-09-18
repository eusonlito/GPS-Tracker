<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Controller;

use App\Domains\Shared\Controller\ControllerWebAbstract as SharedControllerWebAbstract;

abstract class ControllerWebAbstract extends SharedControllerWebAbstract
{
    /**
     * @return void
     */
    protected function initCustom(): void
    {
        if ($name = $this->request->route()?->getName()) {
            $ROUTE_TITLE = __('in-sidebar.'.explode('.', $name)[0]);
        } else {
            $ROUTE_TITLE = '';
        }

        view()->share([
            'ROUTE_TITLE' => $ROUTE_TITLE,
        ]);
    }
}
