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
        $this->cmd = sprintf(
            'nohup %s %s %s >> %s 2>&1 &',
            Exec::php(),
            escapeshellcmd(base_path('artisan')),
            escapeshellcmd($this->command),
            escapeshellcmd($this->log)
        );
    }

    /**
     * @return void
     */
    protected function logOpen(): void
    {
        file_put_contents($this->log, $this->logContents(), FILE_APPEND);
    }

    /**
     * @return string
     */
    protected function logContents(): string
    {
        return "\n".'['.$this->timestamp().'] '.$this->cmd."\n\n";
    }

    /**
     * @return string
     */
    protected function timestamp(): string
    {
        return date_create()->format('Y-m-d H:i:s.v P');
    }

    /**
     * @return void
     */
    protected function launch(): void
    {
        exec($this->cmd);
    }
}
