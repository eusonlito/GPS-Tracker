<?php declare(strict_types=1);

namespace App\Domains\QueueFail\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class QueueFail extends BuilderAbstract
{
    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'ASC');
    }
}
