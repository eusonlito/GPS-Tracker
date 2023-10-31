<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = trim($this->data['name']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkName();
    }

    /**
     * @return void
     */
    protected function checkName(): void
    {
        if ($this->checkNameExists()) {
            $this->exceptionValidator(__('maintenance-item-create.error.exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkNameExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byName($this->data['name'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }
}
