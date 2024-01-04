<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Server\Model\Server
     */
    public function handle(): Model
    {
        if (config('demo.enabled')) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->check();
        $this->save();
        $this->start();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkPort();
        $this->checkProtocol();
    }

    /**
     * @return void
     */
    protected function checkPort(): void
    {
        if (Model::query()->byIdNot($this->row->id ?? 0)->byPort($this->data['port'])->count()) {
            $this->exceptionValidator(__('server-create.error.port-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkProtocol(): void
    {
        if (array_key_exists($this->data['protocol'], config('protocols')) === false) {
            $this->exceptionValidator(__('server-create.error.protocol-not-exists'));
        }
    }

    /**
     * @return void
     */
    protected function start(): void
    {
        $this->factory()->action($this->startData())->startPorts();
    }

    /**
     * @return array
     */
    protected function startData(): array
    {
        return ['ports' => [$this->row->port]];
    }
}
