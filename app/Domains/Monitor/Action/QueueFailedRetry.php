<?php declare(strict_types=1);

namespace App\Domains\Monitor\Action;

use Illuminate\Support\Facades\Artisan;

class QueueFailedRetry extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->retry();
    }

    /**
     * @return void
     */
    protected function retry(): void
    {
        Artisan::call('queue:retry', ['id' => $this->data['id']]);
    }
}
