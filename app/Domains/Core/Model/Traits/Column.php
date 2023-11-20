<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait Column
{
    /**
     * @return array
     */
    public static function getTableColumns(): array
    {
        return static::db()->getSchemaBuilder()->getColumnListing(static::TABLE);
    }
}
