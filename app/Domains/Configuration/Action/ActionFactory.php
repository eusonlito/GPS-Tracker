<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Configuration\Model\Configuration
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function appBind(): void
    {
        $this->actionHandle(AppBind::class);
    }

    /**
     * @return mixed
     */
    public function dump(): mixed
    {
        return $this->actionHandle(Dump::class, $this->validate()->dump());
    }

    /**
     * @return \App\Domains\Configuration\Model\Configuration
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }
}
