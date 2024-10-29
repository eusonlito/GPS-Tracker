<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Database;

use InvalidArgumentException;
use App\Domains\Monitor\Service\Database\Driver\DriverAbstract;
use App\Domains\Monitor\Service\Database\Driver\MySQL;
use App\Domains\Monitor\Service\Database\Driver\PgSQL;

class Database
{
    /**
     * @var \App\Domains\Monitor\Service\Database\Driver\DriverAbstract
     */
    protected DriverAbstract $driver;

    /**
     * @return \App\Domains\Monitor\Service\Database\Driver\DriverAbstract
     */
    protected function driver(): DriverAbstract
    {
        if (isset($this->driver)) {
            return $this->driver;
        }

        $driver = config('database.connections.'.config('database.default').'.driver');

        return $this->driver = match ($driver) {
            'pgsql' => new PgSQL(),
            'mysql' => new MySQL(),
            default => throw new InvalidArgumentException(sprintf('Database %s is not supported', $driver)),
        };
    }

    /**
     * @return array
     */
    public function size(): array
    {
        return $this->driver()->size();
    }

    /**
     * @return array
     */
    public function count(): array
    {
        return $this->driver()->count();
    }
}
