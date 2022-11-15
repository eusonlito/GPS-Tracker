<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model\Traits;

use App\Domains\DeviceAlarm\Service\Type\Manager as TypeManager;
use App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

trait TypeFormat
{
    /**
     * @var \App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $typeFormat;

    /**
     * @param ?array $config = null
     *
     * @return \App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract
     */
    public function typeFormat(?array $config = null): TypeFormatAbstract
    {
        return $this->typeFormat ??= TypeManager::new()->factory($this->type, $config ?? $this->config);
    }
}
