<?php declare(strict_types=1);

namespace App\Services\Command;

use App\Services\Filesystem\Directory;

class Artisan
{
    /**
     * @const string
     */
    protected const LOG = '/dev/null';

    /**
     * @var string
     */
    protected string $log = '/dev/null';

    /**
     * @var bool
     */
    protected bool $logDaily = false;

    /**
     * @var string
     */
    protected string $cmd;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $command
     *
     * @return self
     */
    public function __construct(protected string $command)
    {
    }

    /**
     * @param string|bool $path = true
     *
     * @return self
     */
    public function log(string|bool $path = true): self
    {
        $this->logFile($path);

        return $this;
    }

    /**
     * @param bool $logDaily = true
     *
     * @return self
     */
    public function logDaily(bool $logDaily = true): self
    {
        $this->logDaily = $logDaily;
        $this->log($logDaily);

        return $this;
    }

    /**
     * @return void
     */
    public function exec(): void
    {
        $this->cmd();
        $this->logOpen();
        $this->launch();
    }

    /**
     * @param string|bool $path
     *
     * @return string
     */
    protected function logFile(string|bool $path): string
    {
        $this->log = $this->logFilePath($path);

        Directory::create($this->log, true);

        return $this->log;
    }

    /**
     * @param string|bool $path
     *
     * @return string
     */
    protected function logFilePath(string|bool $path): string
    {
        if (empty($path)) {
            return static::LOG;
        }

        if ($path === true) {
            $path = $this->command;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return storage_path('logs/artisan/'.$this->logFileDatePrefix().$this->logFileCommand($path));
    }

    /**
     * @return string
     */
    protected function logFileDatePrefix(): string
    {
        return date_create()->format('Y/m/d/'.($this->logDaily ? '' : 'H_i_s_u-'));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function logFileCommand(string $path): string
    {
        return str_slug(preg_replace('/\W/', '-', $path)).'.log';
    }

    /**
     * @return void
     */
    protected function cmd(): void
    {
        $this->cmd = 'nohup '.$this->php().' '.base_path('artisan').' '.$this->command
            .' >> '.$this->log.' 2>&1 &';
    }

    /**
     * @return string
     */
    protected function php(): string
    {
        if ($this->phpIsCli()) {
            return PHP_BINARY;
        }

        $version = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;

        $cmd = 'type php'.$version.' 2>/dev/null || type php 2>/dev/null';
        $php = Exec::cmdArray($cmd);

        return end($php);
    }

    /**
     * @return bool
     */
    protected function phpIsCli(): bool
    {
        return (PHP_SAPI === 'cli') || defined('STDIN');
    }

    /**
     * @return void
     */
    protected function logOpen(): void
    {
        file_put_contents($this->log, "\n".$this->cmd."\n\n", FILE_APPEND);
    }

    /**
     * @return void
     */
    protected function launch(): void
    {
        exec($this->cmd);
    }
}
