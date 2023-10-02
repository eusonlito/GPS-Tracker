<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Shared\Service\Controller\Map as ControllerService;

class Map extends ControllerAbstract
{
    /**
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $slug): Response
    {
        $this->publicIsAvailable($slug);

        $this->meta('title', __('shared-map.meta-title'));

        return $this->page('shared.map', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request)->data();
    }
}
