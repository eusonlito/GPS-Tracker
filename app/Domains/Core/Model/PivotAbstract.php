<?php declare(strict_types=1);

namespace App\Domains\Core\Model;

use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;
use App\Domains\Core\Model\Traits\Column as ColumnTrait;
use App\Domains\Core\Model\Traits\DateDisabled as DateDisabledTrait;
use App\Domains\Core\Model\Traits\MutatorDisabled as MutatorDisabledTrait;

abstract class PivotAbstract extends Pivot
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
}
