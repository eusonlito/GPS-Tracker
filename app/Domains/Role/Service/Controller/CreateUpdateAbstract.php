<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Controller;

use App\Domains\Alarm\Service\Type\Manager as TypeManager;
use App\Domains\Position\Model\Position as PositionModel;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @var \App\Domains\Alarm\Service\Type\Manager
     */
    protected TypeManager $typeManager;

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * @return void
     */
    protected function typeManager()
    {
        $this->typeManager = TypeManager::new();
    }

    /**
     * @return array
     */
    protected function dataCommon(): array
    {
        return $this->dataCore() + [
            'types' => $this->types(),
            'type' => $this->type(),
            'position' => $this->position(),
        ];
    }

    /**
     * @return array
     */
    protected function types(): array
    {
        return $this->typeManager->titles();
    }

    /**
     * @return ?\App\Domains\Position\Model\Position
     */
    protected function position(): ?PositionModel
    {
        if ($this->type() === null) {
            return null;
        }

        return $this->cache(
            fn () => PositionModel::query()
                ->byUserId($this->user()->id)
                ->orderByDateUtcAtDesc()
                ->first()
        );
    }
}
