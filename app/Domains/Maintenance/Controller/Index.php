<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Http\Response;
use App\Domains\Maintenance\Controller\Service\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('maintenance-index.meta-title'));

        return $this->page('maintenance.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
