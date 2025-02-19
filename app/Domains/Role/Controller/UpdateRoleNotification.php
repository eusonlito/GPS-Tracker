<?php

declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Service\Controller\UpdateRoleNotification as ControllerService;

class UpdateRoleNotification extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        $this->meta('title', __('role-update-role-notification.meta-title', ['title' => $this->row->name]));

        return $this->page('role.update-role-notification', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
