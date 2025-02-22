<?php

declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Http\Response;
use App\Domains\Role\Model\Role as Model;

class Edit extends ControllerAbstract
{
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', __('role-edit.meta-title'));

        return $this->page('role.edit', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return [
            'row' => $this->row,
        ];
    }
}
