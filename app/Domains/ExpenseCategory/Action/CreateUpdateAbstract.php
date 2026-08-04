<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\ExpenseCategory\Model\ExpenseCategory
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
        $this->dataGlobal();
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
    protected function dataGlobal(): void
    {
        if ($this->auth->admin === false) {
            $this->data['global'] = false;

            return;
        }

        if ($this->row?->isSystem()) {
            $this->data['global'] = true;
        }
    }

    /**
     * @return void
     */
    protected function dataUserId(): void
    {
        if ($this->data['global']) {
            $this->data['user_id'] = null;

            return;
        }

        if ($this->row?->user_id) {
            $this->data['user_id'] = $this->row->user_id;

            return;
        }

        parent::dataUserId();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkSystem();
        $this->checkGlobal();
        $this->checkName();
    }

    /**
     * @return void
     */
    protected function checkSystem(): void
    {
        if (empty($this->row?->isSystem())) {
            return;
        }

        if ($this->auth->admin === false) {
            $this->exceptionValidator(__('expense-category-update.error.system-admin'));
        }
    }

    /**
     * @return void
     */
    protected function checkGlobal(): void
    {
        if (empty($this->row?->isGlobal())) {
            return;
        }

        if ($this->auth->admin === false) {
            $this->exceptionValidator(__('expense-category-update.error.system-admin'));
        }
    }

    /**
     * @return void
     */
    protected function checkName(): void
    {
        if ($this->checkNameExists()) {
            $this->exceptionValidator(__('expense-category-create.error.exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkNameExists(): bool
    {
        $query = Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byName($this->data['name']);

        if ($this->data['user_id']) {
            $query->byUserId($this->data['user_id']);
        } else {
            $query->whereNull('user_id');
        }

        return $query->exists();
    }
}
