<?php declare(strict_types=1);

namespace App\Domains\Configuration\Command;

class Dump extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'configuration:dump {--config} {--server} {--only=}';

    /**
     * @var string
     */
    protected $description = 'Dump Configuration by {--config} {--server} or {--only=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('START');

        $this->requestWithOptions();

        dump($this->factory()->action()->dump());

        $this->info('END');
    }
}
