<?php declare(strict_types=1);

namespace App\Domains\Country\Model;

use App\Domains\Country\Model\Builder\Country as Builder;
use App\Domains\Country\Model\Collection\Country as Collection;
use App\Domains\SharedApp\Model\ModelAbstract;

class Country extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'country';

    /**
     * @const string
     */
    public const TABLE = 'country';

    /**
     * @const string
     */
    public const FOREIGN = 'country_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\Country\Model\Collection\Country
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Country\Model\Builder\Country
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }
}
