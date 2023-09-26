<?php declare(strict_types=1);

namespace App\Domains\Server\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Server extends BuilderAbstract
{
    /**
     * @param int $port
     *
     * @return self
     */
    public function byPort(int $port): self
    {
        return $this->where('port', $port);
    }

    /**
     * @param array $ports
     *
     * @return self
     */
    public function byPorts(array $ports): self
    {
        return $this->whereIntegerInRaw('port', $ports);
    }

    /**
     * @param string $protocol
     *
     * @return self
     */
    public function byProtocol(string $protocol): self
    {
        return $this->where('protocol', $protocol);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('port', 'ASC');
    }
}
