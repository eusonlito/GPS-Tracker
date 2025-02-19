<?php

declare(strict_types=1);

namespace App\Domains\Role\Action;

use App\Domains\Role\Model\Role as Model;
use App\Domains\Role\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @var \App\Domains\Role\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $type;

    /**
     * @return void
     */
    abstract protected function type(): void;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Role\Model\Role
     */
    public function handle(): Model
    {
        $this->type();
        $this->check();
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkType();
        $this->checkSchedule();
    }

    /**
     * @return void
     */
    protected function checkType(): void
    {
        $this->type->validate();
    }

    /**
     * @return void
     */
    protected function checkSchedule(): void
    {
        if (empty($this->data['schedule_start']) && empty($this->data['schedule_end'])) {
            return;
        }

        if (empty($this->data['schedule_start'])) {
            $this->exceptionValidator(__('Role-create.error.schedule_start'));
        }

        if (empty($this->data['schedule_end'])) {
            $this->exceptionValidator(__('Role-create.error.schedule_end'));
        }

        if ($this->data['schedule_start'] >= $this->data['schedule_end']) {
            $this->exceptionValidator(__('Role-create.error.schedule_start_gt_schedule_end'));
        }
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataType();
        $this->dataConfig();
        $this->dataSchedule();
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function dataType(): void
    {
        $this->data['type'] = $this->type->code();
    }

    /**
     * @return void
     */
    protected function dataConfig(): void
    {
        $this->data['config'] = $this->type->config();
    }

    /**
     * @return void
     */
    protected function dataSchedule(): void
    {
        $this->data['schedule_start'] = $this->data['schedule_start'] ?: null;
        $this->data['schedule_end'] = $this->data['schedule_end'] ?: null;
    }
}
