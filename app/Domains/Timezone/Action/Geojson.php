<?php declare(strict_types=1);

namespace App\Domains\Timezone\Action;

use stdClass;
use Throwable;
use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Domains\Timezone\Model\Timezone as Model;
use App\Exceptions\UnexpectedValueException;
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
     * @var bool
     */
    protected bool $exists;

    /**
     * @var bool
     */
    protected bool $overwrite;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->output();
        $this->release();
        $this->files();
        $this->exists();
        $this->overwrite();

        if ($this->overwrite === false) {
            $this->skip();

            return;
        }

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
        $this->print('Checking Releases from %s', static::RELEASE_URL);

        $this->release = Curl::new()->setUrl(static::RELEASE_URL)->send()->getBody('object');

        if (empty($this->release->tag_name)) {
            throw new UnexpectedValueException('Releases can not be loaded');
        }

        $this->print('Last Release %s', $this->release->tag_name);
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        $storage = static::STORAGE_PATH.'/'.$this->release->tag_name;

        $this->url = sprintf(static::DOWNLOAD_URL, $this->release->tag_name);
        $this->zip = base_path($storage.'/timezones-with-oceans.geojson.zip');
        $this->geojson = base_path($storage.'/combined-with-oceans.json');
    }

    /**
     * @return void
     */
    protected function exists(): void
    {
        $this->exists = is_file($this->geojson);
    }

    /**
     * @return void
     */
    protected function overwrite(): void
    {
        $this->overwrite = $this->data['overwrite'] || ($this->exists === false);
    }

    /**
     * @return void
     */
    protected function skip(): void
    {
        $this->print('GeoJSON %s already loaded', $this->fileRelative($this->geojson));
    }

    /**
     * @return void
     */
    protected function download(): void
    {
        $this->print('Downloading %s to %s', $this->url, $this->fileRelative($this->zip));

        helper()->mkdir($this->zip, true);

        file_put_contents($this->zip, fopen($this->url, 'r'));
    }

    /**
     * @return void
     */
    protected function extract(): void
    {
        $this->print('Extracting GeoJSON from ZIP to %s', $this->fileRelative($this->geojson));

        ZipExtract::new($this->zip)->extract(basename($this->geojson));
    }

    /**
     * @return void
     */
    protected function replace(): void
    {
        $this->print('Optimizing GeoJSON %s', $this->fileRelative($this->geojson));

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
        $this->print('Updating %s', $zone->properties->tzid);

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

    /**
     * @param string $file
     *
     * @return string
     */
    protected function fileRelative(string $file): string
    {
        return str_replace(base_path(), '', $file);
    }

    /**
     * @param string $message
     * @param mixed ...$parameters
     *
     * @return void
     */
    protected function print(string $message, mixed ...$parameters): void
    {
        $this->info(sprintf('[%s] '.$message, date('Y-m-d H:i:s'), ...$parameters));
    }
}
