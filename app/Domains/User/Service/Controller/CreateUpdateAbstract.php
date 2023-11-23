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
    protected function request()
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
}
