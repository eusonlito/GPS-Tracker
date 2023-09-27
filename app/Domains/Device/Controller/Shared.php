<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Service\Controller\Shared as ControllerService;

class Shared extends ControllerAbstract
{
    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->rowShared($code);

        $this->meta('title', __('device-shared.meta-title', ['title' => $this->row->name]));

        return $this->page('device.shared', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->row)->data();
    }
}
