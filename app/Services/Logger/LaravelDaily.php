<?php declare(strict_types=1);

namespace App\Services\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LaravelDaily
{
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

        $formatter = new LineFormatter(null, 'Y-m-d H:i:s', true, true);
        $formatter->setMaxNormalizeDepth(1000);
        $formatter->includeStacktraces(true, static fn ($line) => ($production || !str_contains($line, '/vendor/laravel/')) ? $line : null);

        return $formatter;
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    public function handler(): StreamHandler
    {
        $handler = new StreamHandler(storage_path('logs/laravel/'.date('Y-m-d').'.log'), 'DEBUG');
        $handler->setFormatter($this->formatter());

        return $handler;
    }

    /**
     * @return \Monolog\Logger
     */
    public function logger(): Logger
    {
        $logger = new Logger('laravel-daily');
        $logger->pushHandler($this->handler());

        return $logger;
    }
}
