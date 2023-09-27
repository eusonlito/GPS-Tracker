<?php declare(strict_types=1);

namespace App\Domains\Timezone\Command;

class Geojson extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'timezone:geojson {--overwrite}';

    /**
     * @var string
     */
    protected $description = 'Generate Timezones From Remote GeoJSON';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->requestWithOptions();
        $this->factory()->action()->geojson();

        $this->info('[END]');
    }
}
