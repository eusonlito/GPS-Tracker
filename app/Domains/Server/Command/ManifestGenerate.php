<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class ManifestGenerate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:manifest:generate';

    /**
     * @var string
     */
    protected $description = 'Generate the manifest.json file';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->factory()->action()->manifestGenerate();

        $this->info('[END]');
    }
}
