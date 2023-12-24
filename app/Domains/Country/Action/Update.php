<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\Country\Model\Country
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
        $this->dataAlias();
    }

    /**
     * @return void
     */
    protected function dataAlias(): void
    {
        $this->data['alias'] = array_filter(array_map('trim', explode(',', $this->data['alias'])));
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
            $this->exceptionValidator(__('country-update.error.code-exists'));
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
        $this->row->code = $this->data['code'];
        $this->row->name = $this->data['name'];
        $this->row->alias = $this->data['alias'];
        $this->row->save();
    }
}
