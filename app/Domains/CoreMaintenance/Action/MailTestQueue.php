<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

class MailTestQueue extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->send();
    }

    /**
     * @return void
     */
    protected function send(): void
    {
        $this->factory()->mail()->testQueue($this->data['email']);
    }
}
