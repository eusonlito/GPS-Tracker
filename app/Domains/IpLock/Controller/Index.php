<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use Illuminate\Http\Response;
use App\Domains\IpLock\Model\IpLock as Model;
use App\Domains\IpLock\Model\Collection\IpLock as Collection;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('ip-lock-index.meta-title'));

        return $this->page('ip-lock.index', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \App\Domains\IpLock\Model\Collection\IpLock
     */
    protected function list(): Collection
    {
        return Model::query()
            ->list()
            ->get();
    }
}
