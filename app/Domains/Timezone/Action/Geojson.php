<?php declare(strict_types=1);

namespace App\Domains\Timezone\Action;

use stdClass;
use Throwable;
use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Domains\Timezone\Model\Timezone as Model;
use App\Services\Compress\Zip\Extract as ZipExtract;
use App\Services\Http\Curl\Curl;

class Geojson extends ActionAbstract
{
    use InteractsWithIO;

    /**
     * @const string
     */
    protected const STORAGE_PATH = 'storage/app/timezone';

    /**
     * @const string
     */
    protected const RELEASE_URL = 'https://api.github.com/repos/evansiroky/timezone-boundary-builder/releases/latest';

    /**
     * @const string
     */
    protected const DOWNLOAD_URL = 'https://github.com/evansiroky/timezone-boundary-builder/releases/download/%s/timezones-with-oceans.geojson.zip';

    /**
     * @var \stdClass
     */
    protected stdClass $release;

    /**
     * @var string
     */
    protected string $geojson;

    /**
     * @var string
     */
    protected string $zip;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->output();
        $this->release();
        $this->files();
        $this->download();
        $this->extract();
        $this->replace();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function output(): void
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * @return void
     */
    protected function release(): void
    {
        $this->info(sprintf('[%s] Checking Releases', date('Y-m-d H:i:s')));

        $this->release = Curl::new()->setUrl(static::RELEASE_URL)->send()->getBody('object');
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        $this->geojson = base_path(static::STORAGE_PATH.'/combined-with-oceans.json');
        $this->zip = base_path(static::STORAGE_PATH.'/timezones-with-oceans.geojson.zip');
        $this->url = sprintf(static::DOWNLOAD_URL, $this->release->tag_name);
    }

    /**
     * @return void
     */
    protected function download(): void
    {
        if (($this->data['overwrite'] === false) && is_file($this->zip)) {
            return;
        }

        $this->info(sprintf('[%s] Downloading %s', date('Y-m-d H:i:s'), $this->url));

        helper()->mkdir($this->zip, true);

        file_put_contents($this->zip, fopen($this->url, 'r'));
    }

    /**
     * @return void
     */
    protected function extract(): void
    {
        if (($this->data['overwrite'] === false) && is_file($this->geojson)) {
            return;
        }

        $this->info(sprintf('[%s] Extracting ZIP', date('Y-m-d H:i:s')));

        ZipExtract::new($this->zip)->extract(basename($this->geojson));
    }

    /**
     * @return void
     */
    protected function replace(): void
    {
        $this->info(sprintf('[%s] Optimizing GeoJSON', date('Y-m-d H:i:s')));

        file_put_contents(
            $this->geojson,
            preg_replace('/([0-9]\.[0-9]{4})[0-9]+/', '$1', file_get_contents($this->geojson)),
            LOCK_EX
        );
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (json_decode(file_get_contents($this->geojson))->features as $zone) {
            $this->zone($zone);
        }
    }

    /**
     * @param \stdClass $zone
     *
     * @return void
     */
    protected function zone(stdClass $zone): void
    {
        $this->info(sprintf('[%s] Updating %s', date('Y-m-d H:i:s'), $zone->properties->tzid));

        try {
            $this->zoneUpdateOrInsert($zone, 0.005);
        } catch (Throwable $e) {
            $this->zoneUpdateOrInsert($zone, 0);
        }
    }

    /**
     * @param \stdClass $zone
     * @param float $simplify
     *
     * @return void
     */
    protected function zoneUpdateOrInsert(stdClass $zone, float $simplify): void
    {
        Model::query()->updateOrInsert(
            ['zone' => $zone->properties->tzid],
            ['geojson' => Model::geomFromGeoJSON($zone->geometry, $simplify)]
        );
    }
}
