<?php declare(strict_types=1);

namespace App\Domains\State\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;
use App\Domains\State\Model\State as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\State\Model\State
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\State\Model\State
     */
    public function getOrNew(): Model
    {
        return $this->actionHandle(GetOrNew::class, $this->validate()->getOrNew());
    }
}
