<?php declare(strict_types=1);

namespace App\Domains\Refuel\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Refuel\Model\Builder\Refuel as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Refuel extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'refuel';

    /**
     * @const string
     */
    public const TABLE = 'refuel';

    /**
     * @const string
     */
    public const FOREIGN = 'refuel_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Refuel\Model\Builder\Refuel
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }
}
