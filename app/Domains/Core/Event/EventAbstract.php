<?php declare(strict_types=1);

namespace App\Domains\Core\Event;

use Illuminate\Queue\SerializesModels;

abstract class EventAbstract
{
    use SerializesModels;
}
