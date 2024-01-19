<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Service\Controller;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore();
    }
}
