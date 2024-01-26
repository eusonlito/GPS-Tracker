<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Model\Builder;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class DeviceMessage extends BuilderAbstract
{
    /**
     * @param string $serial
     *
     * @return self
     */
    public function byDeviceSerial(string $serial): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->selectOnly('id')->bySerial($serial));
    }

    /**
     * @param bool $response_at = false
     *
     * @return self
     */
    public function whereResponseAt(bool $response_at = false): self
    {
        return $this->when(
            $response_at,
            fn ($q) => $q->whereNotNull('response_at'),
            fn ($q) => $q->whereNull('response_at')
        );
    }

    /**
     * @param bool $sent_at = false
     *
     * @return self
     */
    public function whereSentAt(bool $sent_at = false): self
    {
        return $this->when(
            $sent_at,
            fn ($q) => $q->whereNotNull('sent_at'),
            fn ($q) => $q->whereNull('sent_at')
        );
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
    }
}
