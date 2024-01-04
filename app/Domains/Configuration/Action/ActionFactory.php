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
    public function request(): void
    {
        $this->actionHandle(Request::class);
    }

    /**
     * @return \App\Domains\Configuration\Model\Configuration
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }
}
