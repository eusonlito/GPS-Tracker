<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use Illuminate\Http\Response;
use App\Domains\MaintenanceItem\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('maintenance-item-index.meta-title'));

        return $this->page('maintenance-item.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
