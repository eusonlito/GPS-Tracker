<?php declare(strict_types=1);

namespace App\Domains\Core\Migration\Database;

use LogicException;
use Illuminate\Database\ConnectionInterface;

class DatabaseFactory
{
    /**
     * @param \Illuminate\Database\ConnectionInterface $db
     *
     * @return \App\Domains\Core\Migration\Database\DatabaseAbstract
     */
    public static function get(ConnectionInterface $db): DatabaseAbstract
    {
        return match ($db->getDriverName()) {
            'pgsql' => new PostgreSQL($db),
            'mysql' => new MySQL($db),
            'sqlite' => new SQLite($db),
            default => throw new LogicException('Invalid Database Driver'),
        };
    }
}
