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
        $this->save();
        $this->server();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
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
