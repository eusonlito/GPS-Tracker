<?php

declare(strict_types=1);

namespace App\Domains\Role\Model\Traits;

use App\Domains\Role\Service\Type\Format\FormatAbstract as TypeFormatAbstract;
use App\Domains\Role\Service\Type\Manager as TypeManager;

trait TypeFormat
{
    /**
     * @var \App\Domains\Role\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $typeFormat;

    /**
     * @param ?array $config = null
     *
     * @return \App\Domains\Role\Service\Type\Format\FormatAbstract
     */
    public function typeFormat(?array $config = null): TypeFormatAbstract
    {
        return $this->typeFormat ??= TypeManager::new()->factory($this->type, $config ?? $this->config ?? []);
    }
}
