<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Configuration\Model\Configuration
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->server();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['key'] = str_slug($this->data['key'], '_');
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkKey();
    }

    /**
     * @return void
     */
    protected function checkKey(): void
    {
        if (Model::query()->byIdNot($this->row->id ?? 0)->byKey($this->data['key'])->count()) {
            $this->exceptionValidator(__('configuration-create.error.key-duplicate'));
        }
    }

    /**
     * @return void
     */
    protected function server(): void
    {
        $this->factory('Server')->action(['reset' => true])->startAll();
    }
}
