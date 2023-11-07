<?php declare(strict_types=1);

namespace App\Services\Logger;

class LaravelDaily extends DailyAbstract
{
    /**
     * @return string
     */
    protected function name(): string
    {
        return 'laravel';
    }
}
