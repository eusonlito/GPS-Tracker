<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait Column
{
    /**
     * @psalm-suppress UndefinedConstant
     *
     * @return array
     */
    public static function getTableColumns(): array
    {
        return static::db()->getSchemaBuilder()->getColumnListing(static::TABLE);
    }
}
