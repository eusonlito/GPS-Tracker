<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

use stdClass;

trait Transform
{
    /**
     * @psalm-suppress UndefinedConstant
     *
     * @return \stdClass
     */
    public function toObject(): stdClass
    {
        return json_decode(json_encode($this->toArray()));
    }
}
