<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Trip as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        if (config('demo.enabled') && ($this->row?->user_id === 1)) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkCode();
    }

    /**
     * @return void
     */
    protected function checkCode(): void
    {
        if ($this->checkCodeExists()) {
            $this->exceptionValidator(__('trip-update.error.code-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkCodeExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id)
            ->byCode($this->data['code'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->code = $this->data['code'];
        $this->row->shared = $this->data['shared'];
        $this->row->shared_public = $this->data['shared_public'];
        $this->row->save();
    }
}
