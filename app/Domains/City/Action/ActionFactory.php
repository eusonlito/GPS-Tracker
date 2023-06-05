<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\City\Model\City as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?Model $row;

    /**
     * @return ?\App\Domains\City\Model\City
     */
    public function getOrNew(): ?Model
    {
        return $this->actionHandle(GetOrNew::class, $this->validate()->getOrNew());
    }
}
