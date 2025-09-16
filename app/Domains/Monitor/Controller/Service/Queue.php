<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Domains\QueueFail\Model\Collection\QueueFail as QueueFailCollection;
use App\Domains\QueueFail\Model\QueueFail as QueueFailModel;

class Queue extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(
        protected Request $request,
        protected Authenticatable $auth,
        protected string $name
    ) {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'name' => $this->name(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return string
     */
    protected function name(): string
    {
        return match ($this->name) {
            '', 'pending' => 'pending',
            'delayed' => 'delayed',
            'failed' => 'failed',
            default => $this->exceptionNotFound(),
        };
    }

    /**
     * @return iterable
     */
    protected function list(): iterable
    {
        return match ($this->name) {
            '', 'pending' => $this->pending(),
            'delayed' => $this->delayed(),
            'failed' => $this->failed(),
            default => $this->exceptionNotFound(),
        };
    }

    /**
     * @return array
     */
    protected function pending(): array
    {
        return $this->command('lrange');
    }

    /**
     * @return array
     */
    protected function delayed(): array
    {
        return $this->command('zrange', ':delayed');
    }

    /**
     * @return \App\Domains\QueueFail\Model\Collection\QueueFail
     */
    protected function failed(): QueueFailCollection
    {
        return QueueFailModel::query()
            ->list()
            ->get();
    }

    /**
     * @param string $name
     * @param string $suffix = ''
     *
     * @return array
     */
    protected function command(string $name, string $suffix = ''): array
    {
        return $this->decode(Redis::command($name, ['queues:'.$this->queue($suffix), 0, -1]));
    }

    /**
     * @param array $lines
     *
     * @return array
     */
    protected function decode(array $lines): array
    {
        $lines = array_filter(array_map('json_decode', $lines), 'is_object');

        usort($lines, static fn ($a, $b) => $a->retryUntil <=> $b->retryUntil);

        return $lines;
    }

    /**
     * @param string $suffix = ''
     *
     * @return string
     */
    protected function queue(string $suffix = ''): string
    {
        return config('queue.connections.redis.queue').$suffix;
    }
}
