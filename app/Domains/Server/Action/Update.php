<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->port = $this->data['port'];
        $this->row->protocol = $this->data['protocol'];
        $this->row->debug = $this->data['debug'];
        $this->row->enabled = $this->data['enabled'];

        $this->row->save();
    }
}
