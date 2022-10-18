<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

abstract class UpdateAbstract extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return void
     */
    protected function load(int $id): void
    {
        $this->row($id);
        $this->loadView();
    }

    /**
     * @return void
     */
    protected function loadView(): void
    {
        view()->share([
            'row' => $this->row,
            'previous' => $this->row->previous(),
            'next' => $this->row->next(),
        ]);
    }
}
