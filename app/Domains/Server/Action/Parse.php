<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Protocol\ProtocolFactory;

class Parse extends ActionAbstract
{
    /**
     * @var \App\Domains\Device\Model\Collection\Device
     */
    protected DeviceCollection $devices;

    /**
     * @var array
     */
    protected array $parsed = [];

    /**
     * @var \App\Services\Protocol\ProtocolAbstract
     */
    protected ProtocolAbstract $protocol;

    /**
     * @return array
     */
    public function handle(): array
    {
        $this->protocol();
        $this->devices();
        $this->iterate();

        return $this->parsed;
    }

    /**
     * @return void
     */
    protected function protocol(): void
    {
        $this->protocol = ProtocolFactory::get($this->row->protocol);
    }

    /**
     * @return void
     */
    protected function devices(): void
    {
        $this->devices = DeviceModel::query()
            ->get()
            ->keyBy('serial');
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (explode("\n", $this->data['log']) as $line) {
            $this->line($line);
        }
    }

    /**
     * @param string $line
     *
     * @return void
     */
    protected function line(string $line): void
    {
        [$date_at, $line] = explode(' ', trim($line), 2) + ['', ''];

        $resources = $this->protocol->resources($line, $this->parsed[0]['data'] ?? []);

        $this->parsed[] = [
            'line' => $line,
            'date_at' => str_replace(['[', ']'], '', $date_at),
            'resources' => $resources,
            'device' => $this->lineDevice($resources),
            'data' => $this->lineData($resources),
        ];
    }

    /**
     * @param array $resources
     *
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function lineDevice(array $resources): ?DeviceModel
    {
        foreach ($resources as $resource) {
            return $this->devices->get($resource->serial());
        }

        return null;
    }

    /**
     * @param array $resources
     *
     * @return array
     */
    protected function lineData(array $resources): array
    {
        if ($resources) {
            return $resources[0]->data();
        }

        return [];
    }
}
