<?php declare(strict_types=1);

namespace App\Domains\Position\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\City\Model\City as CityModel;
use App\Domains\Position\Model\Builder\Position as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\SharedApp\Model\Traits\Gis as GisTrait;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

class Position extends ModelAbstract
{
    use GisTrait;

    /**
     * @var string
     */
    protected $table = 'position';

    /**
     * @const string
     */
    public const TABLE = 'position';

    /**
     * @const string
     */
    public const FOREIGN = 'position_id';

    /**
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'direction' => 'integer',
        'signal' => 'integer',
    ];

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(CityModel::class, CityModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timezone(): BelongsTo
    {
        return $this->belongsTo(TimezoneModel::class, TimezoneModel::FOREIGN)->select('id', 'zone');
    }
}
