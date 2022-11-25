<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

class Update extends ActionAbstract
{
    /**
     * @var \App\Domains\Alarm\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $type;

    /**
     * @return \App\Domains\Alarm\Model\Alarm
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
    protected function type(): void
    {
        $this->type = $this->row->typeFormat($this->data['config']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkType();
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
    protected function data(): void
    {
        $this->dataConfig();
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
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->config = $this->data['config'];
        $this->row->telegram = $this->data['telegram'];
        $this->row->enabled = $this->data['enabled'];

        $this->row->save();
    }
}
