<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Shared\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @param string $code = ''
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code = ''): Response
    {
        $this->meta('title', __('shared-index.meta-title'));

        return $this->page('shared.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request)->data();
    }
}
