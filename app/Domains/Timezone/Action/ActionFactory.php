<?php declare(strict_types=1);

namespace App\Domains\Timezone\Action;

use App\Domains\Timezone\Model\Timezone as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Timezone\Model\Timezone
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function geojson(): void
    {
        $this->actionHandle(Geojson::class, $this->validate()->geojson());
    }
}
