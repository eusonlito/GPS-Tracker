<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model;

use App\Domains\Timezone\Model\Builder\Timezone as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;

class Timezone extends ModelAbstract
{
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
