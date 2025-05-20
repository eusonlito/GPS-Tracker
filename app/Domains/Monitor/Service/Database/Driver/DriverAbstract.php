<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Database\Driver;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class DriverAbstract
{
    /**
     * @return array
     */
    abstract public function size(): array;

    /**
     * @return array
     */
    abstract public function count(): array;

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected ConnectionInterface $db;

    /**
     * @var array
     */
    protected array $cache = [];

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function db(): ConnectionInterface
    {
        return $this->db ??= DB::connection();
    }

    /**
     * @param string $key
     *
     * @return string|int
     */
    protected function config(string $key): string|int
    {
        $this->cache[__FUNCTION__] ??= config('database.connections.'.config('database.default'));

        return $this->cache[__FUNCTION__][$key];
    }

    /**
     * @return array
     */
    protected function tables(): array
    {
        return $this->cache[__FUNCTION__] ??= array_column($this->getTables(), 'name');
    }

    /**
     * @return array
     */
    protected function getTables(): array
    {
        return $this->cache[__FUNCTION__] ??= Schema::getTables(schema: $this->getTablesSchema());
    }

    /**
     * @return string
     */
    protected function getTablesSchema(): string
    {
        return $this->config($this->config('driver') === 'pgsql' ? 'search_path': 'database');
    }
}
