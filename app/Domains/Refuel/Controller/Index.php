<?php declare(strict_types=1);

namespace App\Domains\Refuel\Controller;

use Illuminate\Http\Response;
use App\Domains\Refuel\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('refuel-index.meta-title'));

        return $this->page('refuel.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
