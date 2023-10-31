<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\Controller;

use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Timezone\Model\Collection\Timezone as TimezoneCollection;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore() + [
            'timezones' => $this->timezones(),
        ];
    }

    /**
     * @return \App\Domains\Timezone\Model\Collection\Timezone
     */
    protected function timezones(): TimezoneCollection
    {
        return $this->cache(
            fn () => TimezoneModel::query()
                ->list()
                ->get()
        );
    }
}
