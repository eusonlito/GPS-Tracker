<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Http\Response;
use App\Domains\Monitor\Controller\Service\Log as ControllerService;

class Log extends ControllerAbstract
{
    /**
     * @param string $path
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $path = ''): Response
    {
        $this->meta('title', __('monitor-log.meta-title'));

        return $this->page('monitor.log.index', $this->data($path));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function data(string $path): array
    {
        return ControllerService::new($this->request, $this->auth, $path)->data();
    }
}
