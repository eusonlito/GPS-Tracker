<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Http\Response;
use App\Domains\Monitor\Service\Controller\Database as ControllerService;

class Database extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('monitor-database.meta-title'));

        return $this->page('monitor.database', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
