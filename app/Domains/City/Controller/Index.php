<?php declare(strict_types=1);

namespace App\Domains\City\Controller;

use Illuminate\Http\Response;
use App\Domains\City\Controller\Service\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('city-index.meta-title'));

        return $this->page('city.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
