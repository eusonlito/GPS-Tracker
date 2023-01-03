<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Device\Model\Collection\Device as Collection;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('device-index.meta-title'));

        return $this->page('device.index', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->withMessagesCount()
            ->withMessagesPendingCount()
            ->withVehicle()
            ->list()
            ->get();
    }
}
