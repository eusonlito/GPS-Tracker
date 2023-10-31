<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
        ];
    }
}
