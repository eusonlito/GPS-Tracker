<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller\Service;

use App\Domains\Timezone\Model\Collection\Timezone as TimezoneCollection;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore() + [
            'timezones' => $this->timezones(),
            'trip_wait_minutes_default' => app('configuration')->int('trip_wait_minutes'),
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
