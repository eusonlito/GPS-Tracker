<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model;

use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\SharedApp\Model\Traits\Gis as GisTrait;
use App\Domains\Timezone\Model\Builder\Timezone as Builder;

class Timezone extends ModelAbstract
{
    use GisTrait;

    /**
     * @var string
     */
    protected $table = 'timezone';

    /**
     * @const string
     */
    public const TABLE = 'timezone';

    /**
     * @const string
     */
    public const FOREIGN = 'timezone_id';

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
