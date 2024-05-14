<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class OpcachePreload extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:opcache:preload';

    /**
     * @var string
     */
    protected $description = 'Preload Opcache';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->factory()->action()->opcachePreload();

        $this->info('END');
    }
}
