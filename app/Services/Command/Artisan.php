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
        if (empty($path)) {
            return $this->log = static::LOG;
        }

        if ($path === true) {
            $path = storage_path('logs/artisan/'.date_create()->format('Y-m-d/H_i_s_u').'-'.str_slug($this->command).'.log');
        }

        $this->log = $path;

        Directory::create($this->log, true);

        return $this->log;
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
        $version = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;

        return trim(exec('which php'.$version.' || which php'));
    }

    /**
     * @return void
     */
    protected function logOpen(): void
    {
        file_put_contents($this->log, $this->cmd."\n\n");
    }

    /**
     * @return void
     */
    protected function launch(): void
    {
        exec($this->cmd);
    }
}
