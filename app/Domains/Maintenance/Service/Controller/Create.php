<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\File\Model\Collection\File as FileCollection;

class Create extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->request();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate() + [
            'files' => $this->files(),
        ];
    }

    /**
     * @return \App\Domains\File\Model\Collection\File
     */
    protected function files(): FileCollection
    {
        return new FileCollection();
    }
}
