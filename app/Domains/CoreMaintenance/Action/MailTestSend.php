<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

class MailTestSend extends ActionAbstract
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
        $this->factory()->mail()->testSend($this->data['email']);
    }
}
