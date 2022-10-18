<?php declare(strict_types=1);

namespace App\Services\Database;

use DateTime;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Logger
{
    /**
     * @var bool
     */
    protected static bool $listen = false;

    /**
     * @var array
     */
    protected array $files = [];

    /**
     * @var array
     */
    protected array $connections = [];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return self
     */
    public function __construct()
    {
        $this->connections();
    }

    /**
     * @return void
     */
    protected function connections(): void
    {
        if ($this->enabled() !== true) {
            return;
        }

        foreach (config('database.connections') as $name => $config) {
            if ($this->connectionEnabled($name, $config)) {
                $this->connections[$name] = $config;
            }
        }
    }

    /**
     * @return bool
     */
    protected function enabled(): bool
    {
        return (static::$listen === false)
            && (config('logging.channels.database.enabled') === true);
    }

    /**
     * @param string $name
     * @param array $config
     *
     * @return bool
     */
    protected function connectionEnabled(string $name, array $config): bool
    {
        return ($config['log'] ?? false) === true;
    }

    /**
     * @return void
     */
    public function listen(): void
    {
        $this->listenSetup();
        $this->listenStart();

        static::$listen = true;
    }

    /**
     * @return void
     */
    protected function listenSetup(): void
    {
        foreach (array_keys($this->connections) as $name) {
            $this->listenSetupConnection($name);
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function listenSetupConnection(string $name): void
    {
        $this->file($name);

        helper()->mkdir($this->files[$name], true);

        $this->write($name, "\n".'['.date('Y-m-d H:i:s').'] ['.Request::method().'] '.Request::fullUrl()."\n");
    }

    /**
     * @return void
     */
    public function listenStart(): void
    {
        DB::listen(fn ($query) => $this->listenConnectionLog($query->connectionName, $query));
    }

    /**
     * @param string $name
     * @param \Illuminate\Database\Events\QueryExecuted $query
     *
     * @return void
     */
    protected function listenConnectionLog(string $name, QueryExecuted $query): void
    {
        if (empty($this->connections[$name])) {
            return;
        }

        $sql = $query->sql;
        $bindings = $query->bindings;

        foreach ($bindings as $i => $binding) {
            if ($binding instanceof DateTime) {
                $bindings[$i] = $binding->format('Y-m-d H:i:s');
            } elseif (is_string($binding)) {
                $bindings[$i] = "'${binding}'";
            } elseif (is_bool($binding)) {
                $bindings[$i] = $binding ? 'true' : 'false';
            }

            if (is_string($i)) {
                $sql = str_replace(':'.$i, (string)$bindings[$i], $sql);
            }
        }

        $this->write($name, vsprintf(str_replace(['%', '?'], ['%%', '%s'], $sql), $bindings));
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function file(string $name): void
    {
        $file = array_filter(explode('-', preg_replace('/[^a-z0-9]+/i', '-', Request::path())));
        $file = implode('-', array_map(fn ($value) => substr($value, 0, 20), $file)) ?: '-';

        $this->files[$name] = storage_path('logs/query/'.$name.'/'.date('Y-m-d').'/'.substr($file, 0, 150).'.log');
    }

    /**
     * @param string $name
     * @param string $message
     *
     * @return void
     */
    protected function write(string $name, string $message): void
    {
        file_put_contents($this->files[$name], "\n".preg_replace(["/\n+/", "/\n\s+/"], ["\n", ' '], $message), FILE_APPEND | LOCK_EX);
    }
}
