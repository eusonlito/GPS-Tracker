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
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }
}
