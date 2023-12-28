<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

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

    /**
     * @return \App\Domains\Country\Model\Country
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Country\Model\Country
     */
    public function updateMerge(): Model
    {
        return $this->actionHandle(UpdateMerge::class, $this->validate()->updateMerge());
    }
}
