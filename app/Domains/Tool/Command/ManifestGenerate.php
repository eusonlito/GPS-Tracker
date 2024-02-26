<?php declare(strict_types=1);

namespace App\Domains\Tool\Command;

class ManifestGenerate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'tool:manifest:generate';

    /**
     * @var string
     */
    protected $description = 'Generate the manifest.json file';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->factory()->action()->manifestGenerate();

        $this->info('[END]');
    }
}
