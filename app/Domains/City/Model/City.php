<?php declare(strict_types=1);

namespace App\Domains\City\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\City\Model\Builder\City as Builder;
use App\Domains\City\Model\Collection\City as Collection;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\SharedApp\Model\Traits\Gis as GisTrait;
use App\Domains\State\Model\State as StateModel;

class City extends ModelAbstract
{
    use GisTrait;

    /**
     * @var string
     */
    protected $table = 'city';

    /**
     * @const string
     */
    public const TABLE = 'city';

    /**
     * @const string
     */
    public const FOREIGN = 'city_id';

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('selectPointAsLatitudeLongitude', static fn (Builder $q) => $q->selectPointAsLatitudeLongitude());
    }

    /**
     * @param array $models
     *
     * @return \App\Domains\City\Model\Collection\City
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\City\Model\Builder\City
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(StateModel::class, StateModel::FOREIGN)->withDefault();
    }
}
