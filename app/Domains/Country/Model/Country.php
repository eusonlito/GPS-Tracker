<?php declare(strict_types=1);

namespace App\Domains\Country\Model;

use App\Domains\Country\Model\Builder\Country as Builder;
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Country\Model\Builder\Country
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
