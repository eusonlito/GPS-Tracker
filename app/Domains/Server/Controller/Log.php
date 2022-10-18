<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\Response;
use App\Domains\Server\Service\Controller\Log as ControllerService;

class Log extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('server-log.meta-title'));

        return $this->page(...ControllerService::new($this->request)->handle());
    }
}
