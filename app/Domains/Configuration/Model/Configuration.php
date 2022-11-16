<?php declare(strict_types=1);

namespace App\Domains\Configuration\Model;

use App\Domains\Configuration\Model\Builder\Configuration as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;

class Configuration extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'configuration';

    /**
     * @const string
     */
    public const TABLE = 'configuration';

    /**
     * @const string
     */
    public const FOREIGN = 'configuration_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Configuration\Model\Builder\Configuration
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
