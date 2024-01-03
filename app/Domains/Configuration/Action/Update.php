<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;

class Update extends ActionAbstract
{
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
        if ($this->checkKeyExists()) {
            $this->exceptionValidator(__('configuration-create.error.key-duplicate'));
        }
    }

    /**
     * @return bool
     */
    protected function checkKeyExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byKey($this->data['key'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->key = $this->data['key'];
        $this->row->value = $this->data['value'];
        $this->row->description = $this->data['description'];
        $this->row->updated_at = date('Y-m-d H:i:s');

        $this->row->save();
    }

    /**
     * @return void
     */
    protected function server(): void
    {
        $this->factory('Server')->action(['reset' => true])->startAll();
    }
}
