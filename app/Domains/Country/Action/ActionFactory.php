<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Country\Model\Country
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Country\Model\Country
     */
    public function getOrNew(): Model
    {
        return $this->actionHandle(GetOrNew::class, $this->validate()->getOrNew());
    }
}
