<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\City\Model\City as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

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

    /**
     * @return \App\Domains\City\Model\City
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\City\Model\City
     */
    public function updateMerge(): Model
    {
        return $this->actionHandle(UpdateMerge::class, $this->validate()->updateMerge());
    }
}
