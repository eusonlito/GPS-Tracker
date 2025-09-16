<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller;

use Illuminate\Http\Response;
use App\Domains\Configuration\Controller\Service\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('configuration-index.meta-title'));

        return $this->page('configuration.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
