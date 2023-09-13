<?php declare(strict_types=1);

namespace App\Domains\SharedMaintenance\Command;

class DomainCreate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'shared-maintenance:domain:create {--name=} {--action} {--command} {--controller} {--fractal} {--mail} {--middleware} {--model} {--schedule} {--seeder} {--test} {--validate}';

    /**
     * @var string
     */
    protected $description = 'Create a Domain {--name=} with {--action} {--command} {--controller} {--fractal} {--mail} {--middleware} {--model} {--schedule} {--seeder} {--test} {--validate}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('START');

        $this->checkOption('name');
        $this->requestWithOptions();

        $this->factory()->action()->domainCreate();

        $this->info(sprintf('Created Domain %s', $this->option('name')));

        $this->info('END');
    }
}
