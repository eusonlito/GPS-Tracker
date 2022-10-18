<?php declare(strict_types=1);

namespace App\Domains\Shared\Event;

use Illuminate\Queue\SerializesModels;

abstract class EventAbstract
{
    use SerializesModels;
}
