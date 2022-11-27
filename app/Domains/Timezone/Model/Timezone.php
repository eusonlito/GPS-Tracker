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
     * @var array
     */
    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('selectIdZone', static fn (Builder $q) => $q->selectOnly('id', 'zone', 'default'));
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Timezone\Model\Builder\Timezone
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
