<?php declare(strict_types=1);

namespace App\Domains\Country\Controller;

use Illuminate\Http\Response;
use App\Domains\Country\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('country-index.meta-title'));

        return $this->page('country.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
