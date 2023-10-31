<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Shared\Service\Controller\Device as ControllerService;

class Device extends ControllerAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->device($code);

        $this->meta('title', __('shared-device.meta-title', ['title' => $this->device->name]));

        return $this->page('shared.device', $this->data());
    }

    /**
     * @param string $code
     *
     * @return void
     */
    protected function device(string $code): void
    {
        $this->device = DeviceModel::query()
            ->byCode($code)
            ->whereShared()
            ->firstOr(fn () => $this->exceptionNotFound(__('shared-device.error.not-found')));
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->device)->data();
    }
}
