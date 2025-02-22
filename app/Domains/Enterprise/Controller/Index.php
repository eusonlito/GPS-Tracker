<?php

namespace App\Domains\Enterprise\Controller;

use App\Domains\Enterprise\Service\EnterpriseService;
use Illuminate\Http\Response;

class Index extends ControllerAbstract
{
    private EnterpriseService $service;

    public function __construct(EnterpriseService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $data = $this->service::getAll($this->request, $this->auth);
        return $this->page('enterprise.index', compact('data'));
    }

}
