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
        if (($this->row->getCasts()[$this->data['column']] ?? null) !== 'boolean') {
            $this->exceptionValidator(__('validator.column-not-valid'));
        }
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        $this->row->{$this->data['column']} = !$this->row->{$this->data['column']};
        $this->row->save();
    }
}
