<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->delete();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }
}
