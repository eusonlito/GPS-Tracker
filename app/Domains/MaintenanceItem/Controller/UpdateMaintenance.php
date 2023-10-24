<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use Illuminate\Http\Response;
use App\Domains\MaintenanceItem\Service\Controller\UpdateMaintenance as ControllerService;

class UpdateMaintenance extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', __('maintenance-item-update-maintenance.meta-title', ['title' => $this->row->name]));

        return $this->page('maintenance-item.update-maintenance', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
