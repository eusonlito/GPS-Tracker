<?php declare(strict_types=1);

namespace App\Services\Helper;

use App\Services\View\Message;

class Service
{
    /**
     * @return \App\Services\View\Message
     */
    public function message(): Message
    {
        return Message::instance();
    }
}
