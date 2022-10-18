<?php declare(strict_types=1);

namespace App\Domains\Shared\Migration\Database;

use LogicException;
use Illuminate\Database\ConnectionInterface;

class DatabaseFactory
{
    /**
     * @param \Illuminate\Database\ConnectionInterface $db
     *
     * @return self
     */
    public static function get(ConnectionInterface $db)
    {
        return match ($db->getDriverName()) {
            'pgsql' => new PostgreSQL($db),
            'mysql' => new MySQL($db),
            default => throw new LogicException('Invalid Database Driver'),
        };
    }
}
