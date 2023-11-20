<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\File\Model\File as Model;
use App\Domains\File\Model\Collection\File as Collection;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\File\Model\File
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\File\Model\File
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \App\Domains\File\Model\File
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\File\Model\Collection\File
     */
    public function upload(): Collection
    {
        return $this->actionHandle(Upload::class, $this->validate()->upload());
    }
}
