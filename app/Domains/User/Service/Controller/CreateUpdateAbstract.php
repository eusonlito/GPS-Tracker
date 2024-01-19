<?php declare(strict_types=1);

namespace App\Domains\User\Service\Controller;

use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Language\Model\Collection\Language as LanguageCollection;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Timezone\Model\Collection\Timezone as TimezoneCollection;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow();
    }

    /**
     * @return array
     */
    protected function dataCommon(): array
    {
        return $this->dataCore() + [
            'languages' => $this->languages(),
            'timezones' => $this->timezones(),
            'preferences_units_distance' => $this->preferencesUnitsDistance(),
            'preferences_units_volume' => $this->preferencesUnitsVolume(),
            'preferences_units_money' => $this->preferencesUnitsMoney(),
            'preferences_units_decimal' => $this->preferencesUnitsDecimal(),
            'preferences_units_thousand' => $this->preferencesUnitsThousand(),
        ];
    }

    /**
     * @return \App\Domains\Language\Model\Collection\Language
     */
    protected function languages(): LanguageCollection
    {
        return LanguageModel::query()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Timezone\Model\Collection\Timezone
     */
    protected function timezones(): TimezoneCollection
    {
        return TimezoneModel::query()
            ->list()
            ->get();
    }

    /**
     * @return array
     */
    protected function preferencesUnitsDistance(): array
    {
        return [
            'kilometer' => __('user-create.preferences-units-distance-kilometer'),
            'mile' => __('user-create.preferences-units-distance-mile'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsMoney(): array
    {
        return [
            'euro' => __('user-create.preferences-units-money-euro'),
            'dollar' => __('user-create.preferences-units-money-dollar'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsVolume(): array
    {
        return [
            'liter' => __('user-create.preferences-units-volume-liter'),
            'gallon' => __('user-create.preferences-units-volume-gallon'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsDecimal(): array
    {
        return [
            ',' => __('user-create.preferences-units-decimal-comma'),
            '.' => __('user-create.preferences-units-decimal-dot'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsThousand(): array
    {
        return [
            '.' => __('user-create.preferences-units-thousand-dot'),
            ',' => __('user-create.preferences-units-thousand-comma'),
        ];
    }
}
