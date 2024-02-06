<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Http\Response;
use App\Domains\Monitor\Service\Controller\Log as ControllerService;

class Log extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('monitor-log.meta-title'));

        return $this->page(...ControllerService::new($this->request, $this->auth)->handle());
    }
}
