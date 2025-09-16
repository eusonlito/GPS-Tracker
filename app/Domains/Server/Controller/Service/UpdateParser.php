<?php declare(strict_types=1);

namespace App\Domains\Server\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Server\Model\Server as Model;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\ProtocolFactory;

class UpdateParser extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Server\Model\Server $row
     *
     * @return self
     */
    public function __construct(
        protected Request $request,
        protected Authenticatable $auth,
        protected Model $row,
        protected ?array $parsed
    ) {
        $this->log();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        if ($this->request->input('log')) {
            return;
        }

        $file = $this->request->input('file');

        if (array_key_exists($file, $this->files()) === false) {
            return;
        }

        $file = trim(base64_decode(strtr($file, '-_.', '+/=')), '/');
        $file = base_path('storage/logs/'.$file);

        if (is_file($file) === false) {
            return;
        }

        $this->request->merge(['log' => file_get_contents($file)]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
            'parsed' => $this->parsed,
            'protocol' => $this->protocol(),
            'files' => $this->files(),
            'trip' => $this->trip(),
            'positions' => $this->positions(),
        ];
    }

    /**
     * @return \App\Services\Protocol\ProtocolAbstract
     */
    protected function protocol(): ProtocolAbstract
    {
        return ProtocolFactory::get($this->row->protocol);
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        static $cache;

        if (isset($cache)) {
            return $cache;
        }

        $base = base_path('storage/logs');
        $path = sprintf('%s/server/*/*/*/%s-debug.log', $base, $this->row->port);

        $files = [];

        foreach (glob($path) as $file) {
            $file = str_replace($base, '', $file);
            $files[strtr(base64_encode($file), '+/=', '-_.')] = $file;
        }

        $path = sprintf('%s/server/*/*/*/%s.log', $base, $this->row->port);

        foreach (glob($path) as $file) {
            $file = str_replace($base, '', $file);
            $files[strtr(base64_encode($file), '+/=', '-_.')] = $file;
        }

        arsort($files);

        return $cache = $files;
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        if (empty($this->parsed)) {
            return null;
        }

        return new TripModel([
            'distance' => 0,
            'time' => 0,
        ]);
    }

    /**
     * @return ?\App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): ?PositionCollection
    {
        if (empty($this->parsed)) {
            return null;
        }

        $positions = [];
        $i = 0;

        foreach ($this->parsed as $each) {
            foreach ($each['resources'] as $resource) {
                if ($resource->format() !== 'location') {
                    continue;
                }

                $positions[] = new PositionModel([
                    'id' => ++$i,
                    'latitude' => $resource->latitude(),
                    'longitude' => $resource->longitude(),
                    'speed' => $resource->speed(),
                    'direction' => $resource->direction(),
                    'signal' => $resource->signal(),
                    'date_at' => $resource->datetime(),
                    'date_utc_at' => $resource->datetime(),
                ]);
            }
        }

        return new PositionCollection($positions);
    }
}
