<?php declare(strict_types=1);

namespace App\Domains\Core\Model;

use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Model\Traits\Column as ColumnTrait;
use App\Domains\Core\Model\Traits\DateDisabled as DateDisabledTrait;
use App\Domains\Core\Model\Traits\MutatorDisabled as MutatorDisabledTrait;

abstract class ModelAbstract extends Model
{
    use ColumnTrait, DateDisabledTrait, MutatorDisabledTrait;

    /**
     * @var bool
     */
    public static $snakeAttributes = false;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * @param string $column
     *
     * @return \DateTime
     */
    public function datetime(string $column): DateTime
    {
        return new DateTime($this->$column);
    }

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public static function db(): ConnectionInterface
    {
        return DB::connection();
    }

    /**
     * @return \Illuminate\Database\Schema\Builder
     */
    public static function schema(): Builder
    {
        return Schema::connection(static::db()->getName());
    }
}
