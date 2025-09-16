<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Language\Model\Collection\Language as LanguageCollection;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Timezone\Model\Collection\Timezone as TimezoneCollection;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\User\Model\User as Model;

class Update extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\User\Model\User $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
    }

    /**
     * @return void
     */
    public function request(): void
    {
        $this->requestMergeWithRow(['api_key' => $this->requestApiKey()]);
    }

    /**
     * @return string
     */
    public function requestApiKey(): string
    {
        return $this->row->api_key_prefix
            ? ($this->row->api_key_prefix.'-*****-****-****-************')
            : '';
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'admin' => $this->row->admin,
            'manager' => $this->row->manager,
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
            'kilometer' => __('profile-update.preferences-units-distance-kilometer'),
            'knot' => __('profile-update.preferences-units-distance-knot'),
            'mile' => __('profile-update.preferences-units-distance-mile'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsMoney(): array
    {
        return [
            'euro' => __('profile-update.preferences-units-money-euro'),
            'dollar' => __('profile-update.preferences-units-money-dollar'),
            '' => __('profile-update.preferences-units-money-other'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsVolume(): array
    {
        return [
            'liter' => __('profile-update.preferences-units-volume-liter'),
            'gallon' => __('profile-update.preferences-units-volume-gallon'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsDecimal(): array
    {
        return [
            ',' => __('profile-update.preferences-units-decimal-comma'),
            '.' => __('profile-update.preferences-units-decimal-dot'),
        ];
    }

    /**
     * @return array
     */
    protected function preferencesUnitsThousand(): array
    {
        return [
            '.' => __('profile-update.preferences-units-thousand-dot'),
            ',' => __('profile-update.preferences-units-thousand-comma'),
        ];
    }
}
