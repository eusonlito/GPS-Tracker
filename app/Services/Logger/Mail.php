<?php declare(strict_types=1);

namespace App\Services\Logger;

use DateTime;
use DateTimeZone;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Mail
{
    /**
     * @return \Monolog\Logger
     */
    public function __invoke(): Logger
    {
        return $this->logger();
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    public function handler(): StreamHandler
    {
        return new StreamHandler($this->file(), 'DEBUG');
    }

    /**
     * @return string
     */
    protected function file(): string
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));

        return storage_path('logs/mail/'.$date->format('Y/m/d/H-i-s-u').'.log');
    }

    /**
     * @return \Monolog\Logger
     */
    public function logger(): Logger
    {
        $logger = new Logger('mail');
        $logger->pushHandler($this->handler());

        return $logger;
    }
}
