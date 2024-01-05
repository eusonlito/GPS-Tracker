<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller;

use Illuminate\Http\Response;
use App\Domains\Configuration\Service\Controller\Status as ControllerService;

class Status extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('configuration-status.meta-title'));

        return $this->page('configuration.status', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
