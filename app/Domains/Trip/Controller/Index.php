<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('trip-index.meta-title'));

        return $this->page('trip.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
