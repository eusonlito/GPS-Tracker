<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Shared\Service\Controller\Device as ControllerService;
use App\Exceptions\NotFoundException;

class Device extends ControllerAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected Model $row;

    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->row($code);

        $this->meta('title', __('shared-device.meta-title', ['title' => $this->row->name]));

        return $this->page('shared.device', $this->data());
    }

    /**
     * @param string $code
     *
     * @return void
     */
    protected function row(string $code): void
    {
        $this->row = Model::query()->byCode($code)->whereShared()->firstOr(static function () {
            throw new NotFoundException(__('shared-device.error.not-found'));
        });
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->row)->data();
    }
}
