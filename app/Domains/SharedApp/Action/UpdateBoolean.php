<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Action;

use Illuminate\Database\Eloquent\Model;

abstract class UpdateBoolean extends ActionAbstract
{
    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle(): Model
    {
        $this->before();
        $this->check();
        $this->data();
        $this->store();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function before(): void
    {
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (array_key_exists($this->data['column'], $this->row->toArray()) === false) {
            $this->exceptionValidator(__('validator.column-not-valid'));
        }
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['value'] = $this->row->{$this->data['column']};

        if (is_bool($this->data['value'])) {
            $this->data['value'] = empty($this->data['value']);
        } else {
            $this->data['value'] = $this->data['value'] ? null : date('Y-m-d H:i:s');
        }
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        $this->row->{$this->data['column']} = $this->data['value'];
        $this->row->save();
    }
}
