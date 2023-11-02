<?php declare(strict_types=1);

namespace App\Domains\Device\Service\Controller;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request()
    {
        $this->requestMergeWithRow([
            'code' => ($this->row->code ?? helper()->uuid()),
            'user_id' => $this->user(false)->id,
        ]);
    }

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
