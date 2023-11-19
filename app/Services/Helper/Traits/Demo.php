<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Stringable;

trait Demo
{
    /**
     * @return string
     */
    public function demoTimeToReset(): string
    {
        $time = config('demo.reset_time');
        $time = ((date('H:i') > $time) ? 'tomorrow' : 'today').' '.$time;

        return $this->dateDiffHuman(time(), strtotime($time));
    }
}
