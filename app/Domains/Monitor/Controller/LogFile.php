<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Http\Response;
use App\Domains\Monitor\Service\Controller\LogFile as ControllerService;

class LogFile extends ControllerAbstract
{
    /**
     * @param string $path
     * @param string $file
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $path, string $file): Response
    {
        $this->meta('title', __('monitor-log.meta-title'));

        return $this->page('monitor.log.file', $this->data($path, $file));
    }

    /**
     * @param string $path
     * @param string $file
     *
     * @return array
     */
    protected function data(string $path, string $file): array
    {
        return ControllerService::new($this->request, $this->auth, $path, $file)->data();
    }
}
