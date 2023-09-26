<?php declare(strict_types=1);

namespace App\Domains\Server\Fractal;

use App\Domains\Server\Model\Server as Model;
use App\Domains\Core\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Server\Model\Server $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'port', 'protocol', 'debug', 'enabled');
    }
}
