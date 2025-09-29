<?php declare(strict_types=1);

namespace App\Domains\Device\Controller\Service;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'code' => ($this->row->code ?? helper()->uuid()),
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'position_filter_distance_default' => app('configuration')->int('position_filter_distance'),
        ];
    }
}
