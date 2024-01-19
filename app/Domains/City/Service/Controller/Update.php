<?php declare(strict_types=1);

namespace App\Domains\City\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as Model;
use App\Domains\Country\Model\Collection\Country as CountryCollection;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\Collection\State as StateCollection;
use App\Domains\State\Model\State as StateModel;

class Update extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\City\Model\City $row
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
    protected function request(): void
    {
        $this->requestMergeWithRow(data: ['alias' => $this->requestAlias()]);
    }

    /**
     * @return string
     */
    protected function requestAlias(): string
    {
        return $this->request->input('alias')
            ?: implode(',', $this->row->alias ?? []);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
            'states' => $this->states(),
            'countries' => $this->countries(),
        ];
    }

    /**
     * @return \App\Domains\State\Model\Collection\State
     */
    protected function states(): StateCollection
    {
        return StateModel::query()
            ->withCountry()
            ->get()
            ->each(static fn ($each) => $each->name = $each->country->name.' - '.$each->name)
            ->sortBy('name');
    }

    /**
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function countries(): CountryCollection
    {
        return CountryModel::query()
            ->list()
            ->get();
    }
}
