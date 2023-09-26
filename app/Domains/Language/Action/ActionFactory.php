<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\Language\Model\Language as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Language\Model\Language
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
     * @return void
     */
    public function set(): void
    {
        $this->actionHandle(Set::class);
    }
}
