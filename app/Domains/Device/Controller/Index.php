<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('device-index.meta-title'));

        return $this->page('device.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
