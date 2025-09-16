<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Monitor\Service\Database\Database as DatabaseDriver;

class Database extends ControllerAbstract
{
    /**
     * @var \App\Domains\Monitor\Service\Database\Database
     */
    protected DatabaseDriver $driver;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'size' => $this->size(),
            'count' => $this->count(),
        ];
    }

    /**
     * @return \App\Domains\Monitor\Service\Database\Database
     */
    protected function driver(): DatabaseDriver
    {
        return $this->driver ??= new DatabaseDriver();
    }

    /**
     * @return array
     */
    protected function size(): array
    {
        return $this->driver()->size();
    }

    /**
     * @return array
     */
    protected function count(): array
    {
        return $this->driver()->count();
    }
}
