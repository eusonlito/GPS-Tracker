<?php declare(strict_types=1);

namespace App\Services\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class DailyAbstract
{
    /**
     * @var bool
     */
    protected bool $includeStacktracesVendor = false;

    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return \Monolog\Logger
     */
    public function __invoke(): Logger
    {
        return $this->logger();
    }

    /**
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function formatter(): LineFormatter
    {
        $production = app()->isProduction();

        $formatter = new LineFormatter(null, 'c', true, true);
        $formatter->setMaxNormalizeDepth(1000);

        if ($this->includeStacktracesVendor) {
            $formatter->includeStacktraces(true);
        } else {
            $formatter->includeStacktraces(true, static fn ($line) => ($production || !str_contains($line, '/vendor/laravel/')) ? $line : null);
        }

        return $formatter;
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    public function handler(): StreamHandler
    {
        $handler = new StreamHandler($this->handlerFile(), 'DEBUG');
        $handler->setFormatter($this->formatter());

        return $handler;
    }

    /**
     * @return string
     */
    public function handlerFile(): string
    {
        return storage_path('logs/'.$this->name().'/'.date('Y/m/Y-m-d').'.log');
    }

    /**
     * @return \Monolog\Logger
     */
    public function logger(): Logger
    {
        $logger = new Logger($this->name().'-daily');
        $logger->pushHandler($this->handler());

        return $logger;
    }
}
