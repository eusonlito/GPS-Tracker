<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi;

class Delete extends ControllerApiAbstract
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function __invoke(int $id): void
    {
        $this->row($id);
        $this->action()->delete();
    }
}
